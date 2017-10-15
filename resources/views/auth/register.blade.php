@extends('layouts.proman')



@section('content')
<div class="container-fluid">
    <div class="col-lg-6 col-lg-offset-3">
    <h1 class="well text-center">Register Here</h1>
        <div class="row">
            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" placeholder="Enter Name Here.." class="form-control" name="name" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif

                    </div>

                    <div class="form-group">
                        <label for="middlename">Middlename</label>
                        <input id="middlename" type="text" placeholder="Enter Middlename Here.." class="form-control" name="middlename" value="{{ old('middlename') }}">

                        @if ($errors->has('middlename'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('middlename') }}</strong>
                                    </span>
                        @endif

                    </div>

                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input id="lastname" type="text" placeholder="Enter Lastname Here.." class="form-control" name="lastname" value="{{ old('lastname') }}">

                        @if ($errors->has('lastname'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                        @endif

                    </div> <div class="form-group">
                        <label for="title">Position</label>
                        <input id="title" type="text" placeholder="Enter Title Here.." class="form-control" name="title" value="{{ old('title') }}">

                        @if ($errors->has('title'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                        @endif

                    </div>

                        <div class="form-group {{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="password">Company Name</label>
                            <span style="font-size: smaller; color: red" > required *</span>
                            <input id="company" type="company" placeholder="Enter Company Name Here.." class="form-control"   name="company" required>

                            @if ($errors->has('company'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('company') }}</strong>
                                        </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <span style="font-size: smaller; color: red" > required *</span>
                            <input id="email" type="text" placeholder="Enter Email Address Here.." class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif

                        </div>

                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <span style="font-size: smaller; color: red" > required *</span>
                        <input id="password" type="password" placeholder="Enter Password Here.." class="form-control"   name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>


                        <div class="form-group">
                        <label  for="password-confirm">Password Confirmation</label>
                            <span style="font-size: smaller; color: red" > required *</span>
                        <input id="password-confirm" type="password" placeholder="Enter Password Confirmation Here.." class="form-control"  name="password_confirmation" required>

                    </div>


                    <button type="submit" class="btn btn-lg btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection