<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <h3>Password Reset </h3>
    <form action="{{route('updatePassword')}}" method="post" id="editor">
      {{csrf_field()}}
      <div class="form-group">
        <label>Email(required)</label>
        <input type="text" name="email" class="form-control" value="{{$data->email}}">
      </div>
      <div class="form-group">
        <label>Password(required)</label>
        <input type="password" name="password" class="form-control" id="password">
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control">
      </div>
      <div class="form-group">
        <button class="btn btn-primary btn-block btn-flat" type="submit">Submit</button>
      </div>
    </form>
  </div>

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