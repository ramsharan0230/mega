<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>Password Reset</title>
  <!-- GLOBAL MAINLY STYLES-->
  <link href="{{asset('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/admin/vendors/themify-icons/css/themify-icons.css')}}" rel="stylesheet" />
  <!-- THEME STYLES-->
  <link href="{{asset('assets/admin/css/main.css')}}" rel="stylesheet" />
  <!-- PAGE LEVEL STYLES-->
  <link href="{{asset('assets/admin/css/pages/auth-light.css')}}" rel="stylesheet" />
</head>

<body class="bg-silver-300">
  <div class="content">
    <div class="brand">
      <a class="link" href="/">
        {{-- {{$dashboard_composer->site_name}} --}}
      </a>
    </div>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
    @endif
    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      {!! Session::get('message') !!}
    </div>
    @endif
    <h3 class="my-3">Enter your email to get password reset link </h3>
    <form action="{{route('sendEmailLink')}}" method="post">
      {{csrf_field()}}
      <div class="row">
        <div class="col-12">
          <div class="form-group has-feedback">
            <label for="">Enter email</label>
            <input type="email" class="form-control" placeholder="Email" name="email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Send Email Link</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>

  <!-- CORE PLUGINS -->
  <script src="{{asset('assets/admin/vendors/jquery/dist/jquery.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/admin/vendors/popper.js/dist/umd/popper.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
  <!-- PAGE LEVEL PLUGINS -->
  <script src="{{asset('assets/admin/vendors/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript">
  </script>
  <!-- CORE SCRIPTS-->
  <script src="{{asset('assets/admin/js/app.js')}}" type="text/javascript"></script>
  <!-- PAGE LEVEL SCRIPTS-->

</body>

</html>