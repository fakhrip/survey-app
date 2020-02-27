@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    
    @if (Auth::user()->type === "admin")
        <survey-list></survey-list>
    @else
        <respond-list></respond-list>
    @endif
@endsection