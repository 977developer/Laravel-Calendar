@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @role('Admin')
                    <div class="card-header">{{ __('Admin Dashboard') }}</div>
                @else
                    <div class="card-header">{{ __('User Dashboard') }}</div>
                @endrole

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @role('Admin')
                        {{ __('Welcome Admin!') }}
                        <ul class="list-group">
                            <a class="list-group-item list-group-item-action" href="{{ route('users.index') }}">Manage Users</a>
                            <a class="list-group-item list-group-item-action" href="{{ route('roles.index') }}">Manage Roles</a>
                        </ul>
                    @else
                        <div class="response"></div>
                        <div id='calendar'></div>  
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
