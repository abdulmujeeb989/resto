
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="{{env('APP_NAME')}}" />
    <meta name="author" content="{{env('APP_NAME')}}" />
    <title>{{env('APP_NAME')}}</title>
    <!-- Favicon Icon -->
    
    <link rel="icon" type="image/png" href="{!! env('APP_ASSETS') !!}img/favicon.jpeg">
    <!-- Feather Icon-->
    
    <link href="{!! env('APP_ASSETS') !!}vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"><!-- Custom Css -->
    <link href="{!! env('APP_ASSETS') !!}login/css/styles.css" rel="stylesheet" />
</head>
<body class="bg-primary">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                            <div class="card-body">
                                <form  method="POST" action="{{url('waiter_login')}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                 
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputEmailAddress">{{__('label.user_name')}}</label>
                                        <input class="form-control py-4" id="uname" name="uname" type="text" placeholder="Enter email address" />
                                    </div>
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputPassword">{{__('label.password')}}</label>
                                        <input id="pwd" name="pwd" class="form-control py-4"  type="password" placeholder="Enter password" />
                                    </div>
                                  
                                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <input type="submit" value="Login"class="btn btn-lg btn-outline-primary btn-block btn-login text-uppercase font-weight-bold mb-2">
                                    </div>
                                </form>
                                @if (count($errors) > 0)

                                    <div class="alert alert-dark-danger alert-dismissible fade show bg-danger" style="display: block;">
                                        <ul style="list-style: none; padding:0; margin :0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <!-- <div class="card-footer text-center">
                                <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
</div>

</body>
</html>
