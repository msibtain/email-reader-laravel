@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    

                    <div class="row">
                        <div class="col-md-8"><h3>{{ __('Blacklist Links') }}</h3></div>
                        <div class="col-md-4 text-right">
                            <div align="right">
                                <a class="btn btn-primary btn-sm" href="{{url('/blacklists/add')}}">Add Blacklist</a>
                            </div>
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



                    
<table class="table table-striped">
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Column</th>
      <th scope="col">Operator</th>
      <th scope="col">Value</th>
      <th width="120" scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($blacklistlinks as $index => $rule)
    <tr>
      <th scope="row">{{($index+1)}}</th>
      <td>{{$rule->column}}</td>
      <td>{{$rule->operator}}</td>
      <td>{{$rule->value}}</td>
      <td>
        <a  class="btn btn-outline-primary btn-sm" href="{{url('/blacklists/edit/'.$rule->id)}}">Edit</a> 
        <a  class="btn btn-outline-danger btn-sm" href="{{url('/blacklists/delete/'.$rule->id)}}">Delete</a>
      </td>
    </tr>
    @endforeach
    
    
  </tbody>
</table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
