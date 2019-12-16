@extends('layouts.LoginRegister')
@section('LoginRegisterContent')
<section class="body-sign" style="max-width: 650px!important;">
    <div class="center-sign">
        <a href="/" class="logo pull-left">
            <img src="{{('assets/images/tup.png')}}" height="54" alt="Porto Admin" />
        </a>

        <div class="panel panel-sign">
            <div class="panel-title-sign mt-xl text-right" style="background-color:  #800000!important;">
                <h2 class="title text-uppercase text-bold m-none" style="background-color:  #800000!important;"><i class="fa fa-user mr-xs"></i> Sign Up</h2>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group mb-lg">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                            <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" autofocus class="form-control input-lg" placeholder="Dr. Engr. Mr. Ms." />
                            @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group mb-lg">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                            <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus class="form-control input-lg" />
                            @if ($errors->has('first_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group mb-lg">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus class="form-control input-lg" />
                            @if ($errors->has('last_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-lg">
                            <label for="sel1" class="col-md-4 col-form-label text-md-right">Position</label>
                            <select name="role" class = "form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" required class="form-control input-lg" id = "role">
                                <option selected="selected"></option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{ $role->name }}</option>
                                @endforeach
                          <!--       <option value = "2">Department Head</option>
                                <option value = "3">Section Head</option>
                                <option value = "4">Faculty</option> -->
                            </select>

                            @if ($errors->has('role'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('role') }}</strong>
                            </span>
                            @endif
                        </div>
                        
                        <!-- dynamic dropdown start -->
                        <div class="form-group mb-lg">
                            <label for="sel1" class="col-md-6 col-form-label text-md-right">Department</label>
                            <select name="department" class = "form-control{{ $errors->has('department') ? ' is-invalid' : '' }}" class="form-control input-lg" id = "department">
                                <option selected="selected"></option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{ $department->department_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('department'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('department') }}</strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group mb-lg">
                            <label for="sel1" class="col-md-6 col-form-label text-md-right">Course</label>
                            <select name="course" class = "form-control{{ $errors->has('course') ? ' is-invalid' : '' }}" class="form-control input-lg" id = "course">
                                <option selected="selected"></option>
                            </select>

                            @if ($errors->has('course'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('course') }}</strong>
                            </span>
                            @endif

                        </div>
                        <!-- end dynamicdropdown -->
                        
                        <div class="form-group mb-lg">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required class="form-control input-lg" />
                            @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-none">
                            <div class="row">
                                <div class="col-sm-6 mb-lg">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required class="form-control input-lg" />
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 mb-lg">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm&nbsp;Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required class="form-control input-lg" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">

                            </div>
                            <div class="col-sm-4 text-right">
                                <button type="submit" class="btn btn-primary hidden-xs">Sign Up</button>
                                <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign Up</button>
                            </div>
                        </div>

                        <span class="mt-lg mb-lg line-thru text-center text-uppercase">
                            <span>or</span>
                        </span>

                        <p class="text-center">Already have an account? <a href="{{ route('login') }}">Sign In!</a></p>
                    </div>
                </form>
            </div>
        </div>
        <br>
            <!-- <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p> -->
    </div>
</section>   
@endsection

@section('js')
<script>
    $(document).on('change','#department',function(){
        $.ajax({
            type: 'POST',
            url: "{{route('dropdown')}}",
            data: {
                id: $(this).val(),
            },
            success: function(data){
                console.log(data);
                $('#course').empty();
                $('#course').append($("<option></option>"));
                $.each(data, function(k, v) {
                    $('#course').append("<option value = "+data[k].id+">"+data[k].course_name+"</option>");
                });
            },

        });

    });
</script>
@endsection