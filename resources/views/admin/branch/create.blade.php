@extends('admin.layouts.app')
@section('page_title', 'Add branch')

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
          <div class="ibox-title">Create branch </div>

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
          <form method="post" action="{{route('branch.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <label>Exhibitor</label>
                <select name="exhibitor_id" class="form-control">
                  <option value>-- select one --</option>
                  @foreach($exhibitors as $exhibitor)
                  <option value="{{$exhibitor->id}}">
                    {{$exhibitor->title}}
                  </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>District</label>
                <select name="district" class="form-control" id="select2">
                  <option value>-- Please select district --</option>
                  @foreach($districts as $district)
                  <option value="{{$district}}">{{ucfirst($district)}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Address</label>
                <input name="address" value="{{old('address')}}" type="text" class="form-control" required
                  placeholder="Address">
              </div>
              <div class="form-group col-md-6">
                <label>Mobile</label>
                <input name="mobile" value="{{old('mobile')}}" type="text" class="form-control" required
                  placeholder="Mobile">
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="check-list col-md-3">
                    <label class="ui-checkbox ui-checkbox-primary">
                      <input name="publish" type="checkbox" checked>
                      <span class="input-span"></span>Publish</label>
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