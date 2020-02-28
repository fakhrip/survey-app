@extends('layouts.app')

@section('content')
    @if (Auth::user()->type === "admin")
        <survey-detail token="{{ $token }}"></survey-detail>
    @else
        <survey-view token="{{ $token }}"></survey-view>
    @endif
@endsection