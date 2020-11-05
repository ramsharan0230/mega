@extends('front.exhibitor.exhibitorMaster')
@section('page_title', 'Add scholarship/institution')
@section('content')

<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Create scholarship/institution </div>

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
          <form method="post" action="{{route('front.scholarship.store', $detail->id)}}" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <div class="form-group col-md-6">
                <label>Exhibitor</label>
                <select name="exhibitor_id" class="form-control">
                  <option selected value="{{$detail->id}}">{{$detail->title}}</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Type</label>
                <select name="type" class="form-control" id="type">
                  <option value>-- select one --</option>
                  <option value="scholarship">Scholarship</option>
                  <option value="institution">Institution</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Institution Name</label>
                <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="Enter title">
              </div>

              <div class="form-group col-md-6 percent d-none">
                <label>Scholarship percentage</label>
                <input type="text" class="form-control" name="percent" value="{{old('percent')}}"
                  placeholder="Enter percent">
              </div>

              <div class="form-group col-md-6">
                <label>Image</label>
                <input id="fileUpload1" class="form-control" name="image" type="file">
                <div id="wrapper" class="mt-2">
                  <div id="image-holder1">
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label>Logo</label>
                <input id="fileUpload2" class="form-control" name="logo" type="file">
                <div id="wrapper" class="mt-2">
                  <div id="image-holder2">
                  </div>
                </div>
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

<script>
  $('#type').change(function(e) {
    if(e.target.value == 'scholarship') {
      $('.percent').removeClass('d-none').addClass('d-block');
    } else {
      $('.percent').addClass('d-none').removeClass('d-block');
    }

  });
  $(document).ready(function() {
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

</script>

@endpush