@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    

                    <div class="row">
                        <div class="col-md-8"><h3>{{ __('Link Detail') }}</h3></div>
                        <div class="col-md-4 text-right">
                            
                        </div>
                    </div>

                    
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif


                    
                    <b>From Name: </b> {{$email->from_name}}
                    <hr>
                    <b>From Email: </b> {{$email->from_email}}
                    <hr>
                    <b>From Host: </b> {{$email->from_host}}
                    <hr>
                    <b>Subject: </b> {{$email->subject}}
                    <hr>
                    <b>Body: </b> {!!$email->body!!}
                    <hr>
                    <b>Date: </b> {{$email->created_at}}
                    <hr>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection
