@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pb-2">
        <div class="card col-10">
            <kanban-component :auth_user="{{Auth::user()}}" />
        </div>
    </div>
</div>
@endsection