@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel Administratorski</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('admin.users.suck') }}" class="btn btn-primary btn-block">Zarządzaj użytkownikami</a>
        </div>
    </div>
</div>
@endsection
