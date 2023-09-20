@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="card-text text-center mb-5 fw-bold fs-4">
                            Hello, {{ $data->name }}
                        </div>
                        <div class="row">
                            <a class="btn btn-primary" href="{{'/dashboard'}} ">Go to DashBoard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      @endsection
