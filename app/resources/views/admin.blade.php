@extends('layouts.app')

@section('content')
<div class="flex w-full h-full m-8">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex w-auto h-16">
        <button type="button" class="btn btn-primary">Create new survey</button>
    </div>
</div>
@endsection