@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    

                    <div class="row">
                        <div class="col-md-8"><h3>{{ __('Edit Rule') }}</h3></div>
                        <div class="col-md-4 text-right">
                            <div align="right">
                                <a class="btn btn-primary btn-sm" href="{{url('/rules')}}">Back to Rules</a>
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
                                <option @if ($rule->column === "godaddy_valuation") selected @endif value="godaddy_valuation">godaddy_valuation</option>
                                <option @if ($rule->column === "domain_length") selected @endif value="domain_length">domain_length</option>
                                <option @if ($rule->column === "extension") selected @endif value="extension">extension</option>
                                <option @if ($rule->column === "no_of_extensions") selected @endif value="no_of_extensions">no_of_extensions</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Select Operator</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="operator" required>
                                <option value=""></option>
                                <option @if ($rule->operator === "=") selected @endif value="=">Equals ( = )</option>
                                <option @if ($rule->operator === "<") selected @endif value="<">Less than ( < )</option>
                                <option @if ($rule->operator === ">") selected @endif value=">">Greater than ( > )</option>
                                <option @if ($rule->operator === "like") selected @endif value="like">Like</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Value</label>
                            <input type="text" class="form-control" id="txtValue" name="value" value="{{$rule->value}}" />
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary">Update Rule</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
