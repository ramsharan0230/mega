@extends('admin.layouts.app')
@section('title','Add Gallery')

@push('styles')
<style media="screen">
  .img-thumbnail:hover {
    background-color: red;
  }

  .image_cover {
    position: relative;
  }

  .cross-button {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    /* color: red; */
    text-align: center;
    width: 100%;
    height: 100%;
    /* animation-name: fadeInUp;
      animation-duration: .5s; */

  }

  .cross-button:hover {
    background-color: rgba(0, 0, 0, 0.39);
  }

  .cross-button .fa-times {
    font-size: 20px;
    padding-top: 20%;
    text-align: center;
    display: none;
    color: #e6e4e4;
  }

  .cross-button:hover>.fa-times {
    display: block;
  }
</style>
@endpush

@section('content')


<div class="page-content fade-in-up">
  @if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $error)
      <li>{{$error}}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <form method="post" action="{{route('gallery.update', $gallery->id)}}" enctype="multipart/form-data" id="form">
    @csrf
    @method('put')

    <div class="row">
      <div class="col-md-6">
        <div class="ibox">
          <div class="ibox-head">
            <div class="ibox-title">Create Gallery</div>

            <div class="ibox-tools">

            </div>
          </div>
          @if (count($errors) > 0)
          <div class="alert alert-danger message">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <ul>
              @foreach($errors->all() as $error)
              <li>{{$error}}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <div class="ibox-body" style="">


            <!-- sdfsdfasd -->


            <div class="form-group">
              <label>Title</label>
              <input class="form-control" name="title" value="{{$gallery->title}}" type="text"
                placeholder="Enter Title">
            </div>

            <div class="form-group">
              <label>Slug</label>
              <input class="form-control" name="slug" value="{{$gallery->slug}}" type="text" placeholder="Enter Slug">
            </div>


          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="ibox">


          <div class="ibox-body" style="">

            <div class="form-group">
              <label>Thumbnail Of Album</label>
              <input type="file" id="fileUpload" class="form-control" value="" name="image">
              <div id="wrapper" class="mt-2">
                <div id="image-holder">
                  @if($gallery->image)
                  <img src="{{asset('images/thumbnail/'. $gallery->image)}}"
                    style="margin-top:12px; margin-bottom:12px;" height="120px" width="120px" alt="">
                  @endif
                </div>
              </div>
            </div>

            <div class="check-list">
              <label class="ui-checkbox ui-checkbox-primary">
                <input name="published" type="checkbox" {{$gallery->published ? 'checked' : ''}}>
                <span class="input-span"></span>Publish</label>
            </div>
            <br>

            <div class="form-group">
              <button class="btn btn-default" type="submit">Submit</button>
            </div>

          </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="ibox">
          <div class="ibox-body" style="">
            <div class="form-group">
              <label>Images For Gallery</label>
              <input class="form-control" id="gallery-photo-add" type="file" name="image1[]" multiple>

            </div>

            <div class="row">
              <div class="form-group col-md-12">
                <div class="row">
                  @foreach($image as $img)
                  <div class="col-lg-4 mt-2" id="remove-section{{$img->id}}">
                    <div class="image_cover">
                      <div class="cross-button">
                        <div class="fa fa-times remove" id="remove" data-image_id="{{$img->id}}"></div>
                      </div>
                      <img src="/images/main/{{$img->image}}" data-id="{{$img->id}}" width="100%" alt="">
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            <h4 style="color:blue;" id="new-image">New Images</h4>
            <div class="gallery">
            </div>


          </div>


        </div>
      </div>
    </div>

  </form>
</div>


@endsection

@push('scripts')

@include('admin.layouts._partials.imagepreview')
<script type="text/javascript" src="/assets/admin/js/sweetalert.js"> </script>
<script>
  $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });

$(document).ready(function(){
  // $('.remove').click(function(){
  //   var datas = $(this).data("image_id");
  // // console.log(data);
  //   var status = confirm('Really want to delete image?');
  //   if(status){
  //
  //   $.ajax({
  //      method: 'post',
  //      url: "{{route('removeImage')}}",
  //      data: {datas:datas},
  //
  //      success:function(data){
  //        // var removeSection = #dami + datas;
  //        // console.log(removeSection);
  //        $("#remove-section"+datas).replaceWith($("#remove-section"+datas).next());
  //        // $(removeSection).remove();
  //          }
  //   });
  // }
  //
  // })
})
$(function() {

  $('#new-image').hide();
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {
      // console.log(input.files);
      // console.log(placeToInsertImagePreview);

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview).css({'width' : '100px' , 'height' : '100px', 'margin-right': '10px', 'margin-top': '10px'});
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        $('#new-image').show();
        imagesPreview(this, 'div.gallery');
    });
});





</script>
<script type="text/javascript">
  $('body').on('click', '.remove',function(e){
         e.preventDefault();
         // console.log('ada');
         var datas = $(this).data("image_id");
         // var exam_id = $(this).data('exam_token');
             Swal.fire({
                 title: 'Are you sure you want to delete this Image?',
                 type: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes!'
             }).then((result) => {
             if (result.value) {
               $.ajax({
                  method: 'post',
                  url: "{{route('removeImage')}}",
                  data: {datas:datas},

                  success:function(data){
                    // var removeSection = #dami + datas;
                    // console.log(removeSection);
                    ajaxSuccess();
                    $("#remove-section"+datas).replaceWith($("#remove-section"+datas).next());
                    // $(removeSection).remove();
                      }
               });

             }
         })
     })

     function ajaxSuccess(){
            Swal.fire({
                type: 'success',
                title: 'Deleted!!!',
                html: '<div class="error_message">Image Deleted Successfully.</div>' ,
                confirmButtonText: 'Close',
                timer: 10000,
                position: 'top-end',
                animation: false,
                customClass: {
                    popup: 'animated fadeInDown'
                }
            });
        }

</script>

@endpush