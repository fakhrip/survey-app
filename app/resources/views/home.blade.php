@extends('layouts.app')

@section('content')
    @if (Auth::user()->type === "admin")
        <survey-list token="{{ $token }}"></survey-list>
    @else
        <respond-list token="{{ $token }}"></respond-list>
    @endif
@endsection