@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Calendars</h2>
            </div>
            <div class="pull-right">
                @can('calendar-create')
                <a class="btn btn-success" href="{{ route('calendars.create') }}"> Create New Product</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($calendars as $calendar)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $calendar->name }}</td>
	        <td>{{ $calendar->detail }}</td>
	        <td>
                <form action="{{ route('calendars.destroy',$calendar->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('calendars.show',$calendar->id) }}">Show</a>
                    @can('calendar-edit')
                    <a class="btn btn-primary" href="{{ route('calendars.edit',$calendar->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('calendar-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $calendars->links() !!}


<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection