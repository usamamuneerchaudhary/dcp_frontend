@extends('layouts.app')

@section('content')
    {{--{{ dd(session('token')) }}--}}
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
            <data-table endpoint="{{env('API_URL')}}api/datatable/users-activity"></data-table>
                <div class="panel-body">


                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
