@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    

                    <div class="row">
                        <div class="col-md-8"><h3>{{ __('Edit Blacklist Link') }}</h3></div>
                        <div class="col-md-4 text-right">
                            <div align="right">
                                <a class="btn btn-primary btn-sm" href="{{url('/blacklists')}}">Back to Blacklist Links</a>
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



                    <form action="" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="exampleInputEmail1">Select Column</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="column" required>
                                <option value=""></option>
                                <option @if ($blacklistlinks->column === "Subject") selected @endif value="Subject">Subject</option>
                                <option @if ($blacklistlinks->column === "Link") selected @endif value="Link">Link</option>
                                <option @if ($blacklistlinks->column === "From Address") selected @endif value="From Address">From Address</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Select Operator</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="operator" required>
                                <option value=""></option>
                                <option @if ($blacklistlinks->operator === "=") selected @endif value="=">Equals ( = )</option>
                                <option @if ($blacklistlinks->operator === "like") selected @endif value="like">Like</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Value</label>
                            <input type="text" class="form-control" id="txtValue" name="value" value="{{$blacklistlinks->value}}" />
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary">Update</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
