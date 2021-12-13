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
<script type="text/javascript">
  window.page = 'homepage';
</script>
@endsection