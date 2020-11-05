@extends('admin.layouts.app')
@section('page_title', 'Edit scholarship/institution')
@section('content')

<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Edit scholarship/institution</div>
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
          <form method="post" action="{{route('scholarship.update', $detail->id)}}" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="row">
              <div class="form-group col-md-6">
                <label>Exhibitor</label>
                <select name="exhibitor_id" class="form-control">
                  <option value>-- select one --</option>
                  @foreach($exhibitors as $exhibitor)
                  <option value="{{$exhibitor->id}}" {{$exhibitor->id == $detail->exhibitor_id ? 'selected' : ''}}>
                    {{$exhibitor->title}}
                  </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Type</label>
                <select name="type" class="form-control" id="type">
                  <option value>-- select one --</option>
                  <option value="scholarship" {{$detail->type== 'scholarship' ? 'selected' : ''}}>Scholarship</option>
                  <option value="institution" {{$detail->type== 'institution' ? 'selected' : ''}}>Institution</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Institution Name</label>
                <input type="text" class="form-control" name="title" value="{{$detail->title}}"
                  placeholder="Enter title">
              </div>

              <div class="form-group col-md-6 percent d-none">
                <label>Scholarship percentage</label>
                <input type="text" class="form-control" name="percent" value="{{$detail->percent}}"
                  placeholder="Enter percent">
              </div>

              <div class="form-group col-md-6">
                <label>Listing Image</label>
                <input id="fileUpload1" class="form-control" value="{{$detail->image}}" name="image" type="file">
                <div id="wrapper" class="mt-2">
                  <div id="image-holder1">
                    @if($detail->image)
                    <img src="{{asset('images/thumbnail/'. $detail->image)}}"
                      style="margin-top:12px; margin-bottom:12px;" height="120px" width="120px" alt="">
                    @endif
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label>Logo</label>
                <input id="fileUpload2" class="form-control" value="{{$detail->logo}}" name="logo" type="file">
                <div id="wrapper" class="mt-2">
                  <div id="image-holder2">
                    @if($detail->logo)
                    <img src="{{asset('images/main/'. $detail->logo)}}" style="margin-top:12px; margin-bottom:12px;"
                      height="120px" width="120px" alt="">
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="check-list col-md-3">
                    <label class="ui-checkbox ui-checkbox-primary">
                      <input name="publish" type="checkbox" {{ $detail->publish == 1 ? 'checked' : ''}}>
                      <span class="input-span"></span>Publish</label>
                  </div>
                  <div class="check-list col-md-3">
                    <label class="ui-checkbox ui-checkbox-primary">
                      <input name="show_in_home" type="checkbox" {{ $detail->show_in_home == 1 ? 'checked' : ''}}>
                      <span class="input-span"></span>Show in home</label>
                  </div>
                </div>
              </div>
            </div>
            <br>

            <div class="form-group">
              <button class="btn btn-primary btn-block" type="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>



</div>

@endsection

@push('scripts')

<script>
  const type = '{{$detail->type}}';

  $('#type').change(function(e) {
    if(e.target.value == 'scholarship') {
      $('.percent').removeClass('d-none').addClass('d-block');
    } else {
      $('.percent').addClass('d-none').removeClass('d-block');
    }
  });
  $(document).ready(function() {
      if(type == 'scholarship') {
        $('.percent').removeClass('d-none').addClass('d-block');
      } else {
        $('.percent').addClass('d-none').removeClass('d-block');
      }

      fileUpload('#fileUpload1', '#image-holder1');
      fileUpload('#fileUpload2', '#image-holder2');
   });
   function fileUpload($selector, $imageHolder) {
       $($selector).on('change', function() {
           if (typeof(FileReader) != "undefined") {
               var image_holder = $($imageHolder);
               // $("#image-holder").siblings().remove();
               $($imageHolder).children().remove();
               var reader = new FileReader();
               reader.onload = function(e) {
                   $("<img />", {
                       "src": e.target.result,
                       "class": "thumb-image",
                       "width": '50%'
                   }).appendTo(image_holder);
               }
               image_holder.show();
               reader.readAsDataURL($(this)[0].files[0]);
           } else {
               alert("This browser does not support FileReader.");
           }
       });
   }
   function checkType(e = '') {

   }

</script>

@endpush