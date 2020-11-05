@extends('admin.layouts.app')
@section('page_title', 'Add exhibitor')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
  /* .select2-container--default .select2-selection--single {
    background-color: transparent;
    border: none;
    border-bottom: 1px solid #c5cfd3;
    margin-bottom: 13px;
  } */
</style>
@endpush

@section('content')

<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Create exhibitor</div>

          <div class="ibox-tools">

          </div>
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
        <div class="ibox-body" style="">
          <form method="post" action="{{route('exhibitor.store')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="role" value="exhibitor">
            <div class="row">
              <div class="col-md-8">

                <div class="form-group">
                  <label>Full Name</label>
                  <input type="text" class="form-control" name="name" value="{{old('name')}}"
                    placeholder="Enter full name">
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" value="{{old('email')}}"
                    placeholder="Enter email">
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password" value="{{old('password')}}"
                    placeholder="Enter Password">
                </div>

                <div class="form-group">
                  <label>Re-Password</label>
                  <input type="password" class="form-control" name="password_confirmation"
                    value="{{old('password_confirmation')}}" placeholder="Enter Password">
                </div>



                <div class="check-list">
                  <label class="ui-checkbox ui-checkbox-primary">
                    <input name="publish" type="checkbox" checked>
                    <span class="input-span"></span>Publish</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="ibox">
                  <div class="ibox-head">
                    <div class="ibox-title">Permissions</div>
                    <div class="ibox-tools">
                    </div>
                  </div>
                  <div class="ibox-body" style="">
                    @if(isset($access_options) && count($access_options))
                    @foreach($access_options as $key => $option)
                    <div class="check-list mb-3">
                      <label class="ui-checkbox ui-checkbox-primary">
                        <input type="checkbox" value={{ $key }} name="access[]">
                        <span class="input-span"></span>{{ $option }}
                      </label>
                    </div>
                    @endforeach
                    @endif

                  </div>
                </div>
              </div>
            </div>
            <br>

            <div class="form-group">
              <button class="btn btn-block btn-primary" type="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
  $('#select2').select2();

</script>
@endpush
{{--
<div class="form-group">
  <label>District</label>
  <select name="district" class="form-control" id="select2">
    <option value>-- Please select district --</option>
    @foreach($districts as $district)
    <option value="{{$district}}">{{ucfirst($district)}}</option>
@endforeach
</select>
</div>
<div class="form-group">
  <label>Address</label>
  <input name="address" value="{{old('address')}}" type="text" class="form-control" required placeholder="Address">
</div>
<div class="form-group">
  <label>Specific country</label>
  <select name="country" class="form-control">
    <option value>-- Please select country --</option>
    @foreach($countries as $country)
    <option value="{{$country->id}}">{{ucfirst($country->title)}}</option>
    @endforeach
  </select>
</div> --}}