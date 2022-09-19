@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Currency Exchange') }}</div>

                <div class="card-body">

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

                    
            <div class="card-body">
                        <form id="currency-exchange-rate" action="{{ route('currency.store') }}" method="post" class="form-group">
                        @csrf
                       

                        <div class="row mb-3">
                     
                        <label for="base" class="col-md-4 col-form-label text-md-end">{{ __('Base') }}</label>
                        <div class="col-md-6">
                        <select name="base" class="form-control"> 
                            @foreach($currency_rates->rates as $key=>$currency)
                                <option value="{{$key}}">{{$key}}</option>
                            @endforeach
                        </select>
                        </div>
                        </div>  

                        <div class="row mb-3">
                        <label for="Date_from" class="col-md-4 col-form-label text-md-end">{{ __('Date_from') }}</label>
                        <div class="col-md-6">
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' name="start_date" class="form-control" />
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                </div>
                        </div>
                        </div>

                        <div class="row mb-3">
                        <label for="Date_to" class="col-md-4 col-form-label text-md-end">{{ __('Date_to') }}</label>
                        <div class="col-md-6">
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' name="end_date"  class="form-control" />
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                </div>
                        </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                 <input type="submit" name="submit" id="btnSubmit" class="btn btn-primary " value="Click To Exchange Rate">
                            </div>
                        </div>

                        </form> 
                      
                      
            </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    
    <script>
    $(document).ready(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    
    });
    </script>
                       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
