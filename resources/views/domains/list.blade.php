@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                  <h3>{{ __('Domains') }}</h3>
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
      <th scope="col">Valuation</th>
      <th scope="col">Length</th>
      <th scope="col">Extension</th>
      <th scope="col">No. of Extensions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($domains as $index => $domain)
    <tr>
      <th scope="row">{{($index+1)}}</th>
      <td>{{$domain->godaddy_valuation}}</td>
      <td>{{$domain->domain_length}}</td>
      <td>{{$domain->extension}}</td>
      <td>{{$domain->no_of_extensions}}</td>
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
