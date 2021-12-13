@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Public Calendar') }}</div>

                <div class="card-body">
                    <div class="response"></div>
                    <div id='calendar'></div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function () {
    var SITEURL = "{{url('/')}}/";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var calendar = $('#calendar').fullCalendar({
      editable: true,
      events: SITEURL + "booking",
      displayEventTime: false,
      editable: true,
      eventRender: function (event, element, view) {
        if (event.allDay === 'true') {
          event.allDay = true;
        } else {
          event.allDay = false;
        }
      },
      selectable: true,
      selectHelper: true,
      select: function (start, end, allDay) {
        // var title = prompt('Event Title:');
        const startTime = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
        const endTime = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
        const allDayTime = allDay;

        Swal.fire({
          input: 'text',
          inputLabel: 'Event Title',
          inputPlaceholder: 'Event Title',
          showCancelButton: true,
          allowOutsideClick: false
        }).then((result) => {
          const title = result.value;

          if (title) {
            $.ajax({
              url: SITEURL + "fullcalendar/create",
              data: 'title=' + title + '&start=' + startTime + '&end=' + endTime,
              type: "POST",
              success: function (data) {
                displayMessage("Added Successfully");
              }
            });

            calendar.fullCalendar('renderEvent',{
              title: title,
              start: startTime,
              end: endTime,
              allDay: allDayTime
            }, true);
            
            calendar.fullCalendar('unselect');
          }
        })
      },
      eventDrop: function (event, delta) {
        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        $.ajax({
          url: SITEURL + 'fullcalendar/update',
          data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
          type: "POST",
          success: function (response) {
            displayMessage('Success', 'The event was updated successfully.' ,'success');
          }
        });
      },
      eventClick: function (event) {
        Swal.fire({
          title: 'Edit Event',
          input: 'text',
          inputValue: event.title,
          showCancelButton: true,
          showDenyButton: true,
          confirmButtonText: 'Edit',
          denyButtonText: `Delete`,
          allowOutsideClick: false
        }).then((result) => {
          if (result.isConfirmed) {
            const title        = result.value;

            const startTime    = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            const endTime      = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            const allDayTime   = event.allDay;

            $.ajax({
              url: SITEURL + 'fullcalendar/update',
              data: 'title=' + title + '&start=' + startTime + '&end=' + endTime + '&id=' + event.id,
              type: "POST",
              success: function (response) {

                event.title  = title;
                event.start  = startTime;
                event.end    = endTime;
                event.allDay = allDayTime;

                calendar.fullCalendar('updateEvent', event , true);
                calendar.fullCalendar('unselect');

                displayMessage('Success', 'The event was updated successfully.' ,'success');
              }
            });
          }

          if (result.isDenied) {
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!',
              allowOutsideClick: false
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  type: "POST",
                  url: SITEURL + 'fullcalendar/delete',
                  data: "&id=" + event.id,
                  success: function (response) {
                    if(parseInt(response) > 0) {
                      $('#calendar').fullCalendar('removeEvents', event.id);
                      displayMessage('Success', 'The event was deleted successfully.' ,'success');
                    }
                  }
                });

              }
            })
          }            
        })
      }
    });
  });

  /**
   * Display alert message
   * 
   * @param {string} message
   * @param {string} event
   * @param {string} result
   */
  function displayMessage(message, event, result) {
    Swal.fire(
      message,
      event,
      result
    )
  }
</script>
@endsection