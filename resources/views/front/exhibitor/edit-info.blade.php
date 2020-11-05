@extends('front.exhibitor.exhibitorMaster')

@section('page_title', 'Edit exhibitor info')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')

<div class="page-content fade-in-up">
   <div class="row">
      <div class="col-md-12">
         <div class="ibox">

            <div class="ibox-head">
               <div class="ibox-title">Other related fields</div>

            </div>

            <div class="ibox-body">
               <div class="clf">
                  <ul class="nav nav-tabs tabs-line nav-fill">
                     <li class="nav-item">
                        <a class="nav-link" href="{{route('front.datetime.list', $detail->id)}}">
                           <i class="ti-menu"></i>
                           Datetime
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{route('front.scholarship.list', $detail->id)}}"><i
                              class="ti-menu"></i>
                           Scholarship/Institution
                        </a>
                     </li>

                  </ul>

               </div>
            </div>
         </div>
      </div>

   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="ibox">
            <div class="ibox-head">
               <div class="ibox-title">Edit exhibitor info</div>
            </div>
            @include('admin.layouts._partials.messages.info')

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
               <form method="post" action="{{route('front.exhibitor.update_info', $detail->id)}}"
                  enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="user_id" value="{{$detail->user_id}}">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="row">
                           <div class="form-group col-md-6">
                              <label>Category</label>
                              <select name="category_id" class="form-control">
                                 <option value>-- select one --</option>
                                 @foreach($categories as $category)
                                 <option value="{{$category->id}}"
                                    {{ $detail->category_id == $category->id ? 'selected' : ''}}>
                                    {{$category->title}}
                                 </option>
                                 @endforeach
                              </select>
                           </div>

                           <div class="form-group col-md-6">
                              <label>District</label>
                              <select name="district" class="form-control" id="select2">
                                 <option value>-- Please select district --</option>
                                 @foreach($districts as $district)
                                 <option value="{{$district}}" {{ $district == $detail->district ? 'selected' : ''}}>
                                    {{ucfirst($district)}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group col-md-6">
                              <label>Address</label>
                              <input name="address" value="{{$detail->address}}" type="text" class="form-control"
                                 required placeholder="Address">
                           </div>
                           <div class="form-group col-md-6">
                              <label>Specific country</label>
                              <select name="country" class="form-control">
                                 <option value>-- Please select country --</option>
                                 @foreach($countries as $country)
                                 <option value="{{$country->id}}" {{$detail->country == $country->id ? 'selected': ''}}>
                                    {{ucfirst($country->title)}}</option>
                                 @endforeach
                              </select>
                           </div>

                           <div class="form-group col-md-6">
                              <label>Interested countries</label>
                              <select name="countries[]" multiple="multiple" id="multiple-select-vendor"
                                 class="js-example-basic-multiple form-control">
                                 <option value>--Please select--</option>
                                 @foreach($dashboard_allCountries as $country)
                                 <option value="{{$country->id}}">{{$country->title}}</option>
                                 @endforeach
                              </select>
                           </div>

                           <div class="form-group col-md-6">
                              <label>Title</label>
                              <input type="text" class="form-control" name="title" value="{{$detail->title}}"
                                 placeholder="Enter title">
                           </div>

                           {{-- <div class="form-group col-md-6">
                              <label>Email link</label>
                              <input type="text" class="form-control" name="email_link" value="{{$detail->email_link}}"
                           placeholder="Enter email link">
                        </div> --}}

                        <div class="form-group col-md-6">
                           <label>Viber(97798********)</label>
                           <input type="text" class="form-control" name="viber" value="{{$detail->viber}}"
                              placeholder="Enter viber link">
                        </div>

                        <div class="form-group col-md-6">
                           <label>Messenger</label>
                           <input type="text" class="form-control" name="messenger" value="{{$detail->messenger}}"
                              placeholder="Enter messenger link">
                        </div>

                        <div class="form-group col-md-6">
                           <label>Whatsapp(97798********)</label>
                           <input type="text" class="form-control" name="whatsapp" value="{{$detail->whatsapp}}"
                              placeholder="Enter whatsapp link">
                        </div>

                        <div class="form-group col-md-6">
                           <label>Image</label>
                           <input id="fileUpload1" class="form-control" value="{{$detail->image}}" name="image"
                              type="file">
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
                           <input id="fileUpload2" class="form-control" value="{{$detail->logo}}" name="logo"
                              type="file">
                           <div id="wrapper" class="mt-2">
                              <div id="image-holder2">
                                 @if($detail->logo)
                                 <img src="{{asset('images/main/'. $detail->logo)}}"
                                    style="margin-top:12px; margin-bottom:12px;" height="120px" width="120px" alt="">
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group col-md-6">
                           <label>Image in Exhibition</label>
                           <input id="fileUpload3" class="form-control" value="{{$detail->exhibition_hall_image}}"
                              name="exhibition_hall_image" type="file">
                           <div id="wrapper" class="mt-2">
                              <div id="image-holder3">
                                 @if($detail->exhibition_hall_image)
                                 <img src="{{asset('images/main/'. $detail->exhibition_hall_image)}}"
                                    style="margin-top:12px; margin-bottom:12px;" height="120px" width="120px" alt="">
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group col-md-12">
                           <label>Document/Brochure</label>
                           <input class="form-control" name="download" type="file">
                        </div>

                        <div class="check-list col-md-12">
                           <label class="ui-checkbox ui-checkbox-primary">
                              <input name="publish" type="checkbox" checked>
                              <span class="input-span"></span>Publish</label>
                        </div>

                        <div class="box-destination-record mt-5">
                           <div class="clf">
                              <div class="row">
                                 <div class="col-md-3">
                                    <ul class="nav nav-tabs tabs-line-left">
                                       <li class="nav-item">
                                          <a class="nav-link active" href="#introduction-1"
                                             data-toggle="tab">Introduction</a>
                                       </li>
                                       <li class="nav-item">
                                          <a class="nav-link" href="#about-1" data-toggle="tab"></i>
                                             About</a>
                                       </li>
                                       <li class="nav-item">
                                          <a class="nav-link" href="#services-1" data-toggle="tab"></i>
                                             Services</a>
                                       </li>
                                       <li class="nav-item">
                                          <a class="nav-link" href="#courses_fees-1" data-toggle="tab"></i>
                                             Courses & Fees </a>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="col-md-9">
                                    <div class="tab-content">
                                       <div class="tab-pane show active border-ck" id="introduction-1">
                                          <textarea class="form-control" name="introduction" rows="8"
                                             cols="80">{{$detail->introduction}}</textarea>
                                       </div>
                                       <div class="tab-pane border-ck" id="about-1">
                                          <textarea class="form-control" name="about"
                                             rows="3">{{$detail->about}}</textarea>
                                       </div>
                                       <div class="tab-pane border-ck" id="services-1">
                                          <textarea class="form-control" name="services"
                                             rows="3">{{$detail->services}}</textarea>
                                       </div>
                                       <div class="tab-pane border-ck" id="courses_fees-1">
                                          <textarea class="form-control" name="courses_fees"
                                             rows="3">{{$detail->courses_fees}}</textarea>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
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

<?php
  $name = [
    'introduction',
    'about',
    'services',
    'courses_fees',
  ];
?>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@foreach($name as $data)
@include('admin.layouts._partials.ckdynamic', ['name' => $data])
@endforeach

<script>
   $(document).ready(function() {
        fileUpload('#fileUpload1', '#image-holder1');
        fileUpload('#fileUpload2', '#image-holder2');
        fileUpload('#fileUpload3', '#image-holder3');
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

<script>
   $("#multiple-select-vendor").select2().val({!! json_encode(@$detail->countries()->pluck('country_id'))
   !!}).trigger('change');
</script>
@endpush