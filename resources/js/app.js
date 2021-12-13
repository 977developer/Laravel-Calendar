$(document).ready(function () {
	$.ajaxSetup({
	  headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});
	
	var calendar = $('#calendar').fullCalendar({
	  events: {
	    url: SITEURL + "booking",
      method: 'GET',
      data: function () { // a function that returns an object
        return {
          page: window.page,
        };
      },
	    failure: function() {
	      alert('there was an error while fetching events!');
	    }
	  },
	  displayEventTime: false,
	  editable: window.page ? false : true,
	  eventColor: '#378006',
	  eventRender: function (event, element, view) {
	    if (event.allDay === 'true') {
	      event.allDay = true;
	    } else {
	      event.allDay = false;
	    }

	    if (event.user) {
	    	element.css('background-color', event.user.color);
    	}
	  },
	  selectable: true,
	  selectHelper: true,
	  select: function (start, end, allDay) {
	  	if (window.page != 'homepage') {
	    	addEvent(start, end, allDay);
    	}
	  },
	  eventDrop: function (event, delta) {
	  	if (window.page != 'homepage') {
	    	dropEvent(event, delta);
    	}
	  },
	  eventClick: function (event) {
	  	if (window.page != 'homepage') {
	    	clickEvent(event);
    	}
	  }
	});
});

/**
* Handle when an event is added
* 
* @param {object} start
* @param {object} end
* @param {bool} allDay
* 
* @returns {void}
*/
function addEvent(start, end, allDay) {
	const startTime = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
	const endTime = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
	const allDayTime = allDay;

	Swal.fire({
	  input: 'text',
	  inputLabel: 'Event Title',
	  inputPlaceholder: 'Event Title',
	  showCancelButton: true,
	  allowOutsideClick: false
	}).then(function (result) {
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

	    $('#calendar').fullCalendar('renderEvent',{
	      title: title,
	      start: startTime,
	      end: endTime,
	      allDay: allDayTime
	    }, true);
	    
	    $('#calendar').fullCalendar('unselect');
	  }
	})
}

/**
* Handle when an event is dropped
* 
* @param {object} event
* @param {object} end
* 
* @returns {void}
*/
function dropEvent(event, delta) {
	var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
	var end   = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
	$.ajax({
	  url: SITEURL + 'fullcalendar/update',
	  data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
	  type: "POST",
	  success: function (response) {
	    displayMessage('Success', 'The event was updated successfully.' ,'success');
	  }
	});
}

/**
* Handle when a date is clicked
* 
* @param {object} event
* @returns {void}
*/
function clickEvent(event) {
	Swal.fire({
	  title: 'Edit Event',
	  input: 'text',
	  inputValue: event.title,
	  showCancelButton: true,
	  showDenyButton: true,
	  confirmButtonText: 'Edit',
	  denyButtonText: `Delete`,
	  allowOutsideClick: false
	}).then(function (result) {
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

	        $('#calendar').fullCalendar('updateEvent', event , true);
	        $('#calendar').fullCalendar('unselect');

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
	    }).then(function (result) {
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
