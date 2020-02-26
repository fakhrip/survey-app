@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Features</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="flex w-full h-auto">
                        <ul>
                            <li>Custom Survey</li>
                            <li>Custom Answer type (text, multiple choice, single choice, datepicker)</li>
                            <li>Duration based Survey</li>
                            <li>Respond detail from respondant</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection