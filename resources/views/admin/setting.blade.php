@extends('admin.layouts.app')

@section('page_title', 'Site Setting')

@push('styles')
<style>
    .form-group label {
        text-transform: capitalize;
    }
</style>
@endpush

@section('content')

<div class="page-content fade-in-up">
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
    <form method="post" action="{{ route('setting.update', $detail->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">SEO Details</div>
                    </div>
                    <div class="ibox-body">
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input class="form-control" type="text" name="meta_title" value="{{$detail->meta_title}}"
                                placeholder="Enter Meta Title">
                        </div>

                        <div class="form-group">
                            <label>Meta Description</label>
                            <input class="form-control" type="text" value="{{$detail->meta_description}}"
                                name="meta_description" placeholder="Enter Meta Description">
                        </div>

                        <div class="form-group">
                            <label>Keywords</label>
                            <input class="form-control" type="text" value="{{$detail->keyword}}" name="keyword"
                                placeholder="Enter Keywords">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Social Media Links</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label>Facebook Link</label>
                                <input class="form-control" type="text" value="{{$detail->facebook}}" name="facebook"
                                    placeholder="Enter facebook link">
                            </div>

                            <div class="col-sm-12 form-group">
                                <label>instagram Link</label>
                                <input class="form-control" type="text" value="{{$detail->instagram}}" name="instagram"
                                    placeholder="Enter instagram link">
                            </div>

                            <div class="col-sm-12 form-group">
                                <label>youtube Link</label>
                                <input class="form-control" type="text" value="{{$detail->youtube}}" name="youtube"
                                    placeholder="Enter youtube link">
                            </div>
                            <div class="col-sm-12 form-group">
                                <label>linkedin Link</label>
                                <input class="form-control" type="text" value="{{$detail->linkedin}}" name="linkedin"
                                    placeholder="Enter linkedin link">
                            </div>
                            

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Site Setting</div>
                    </div>
                    <div class="ibox-body" style="">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Site Name</label>
                                <input class="form-control" type="text" name="site_name" value="{{$detail->site_name}}"
                                    placeholder="Enter Site name">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Chat on Viber</label>
                                <input class="form-control" type="text" value="{{$detail->chat_viber}}" name="chat_viber"
                                    placeholder="9779890909090">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Chat on Whatsapp</label>
                                <input class="form-control" type="text" value="{{$detail->chat_whatsapp}}" name="chat_whatsapp"
                                    placeholder="9779890909090">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Chat on messenger</label>
                                <input class="form-control" type="text" value="{{$detail->chat_messenger}}" name="chat_messenger"
                                    placeholder="Enter messenger link">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Redirect to</label>
                                <select name="redirect_to" class="form-control">
                                    <option value>-- select one --</option>
                                    @foreach($dashboard_exhibitors as $exhibitor)
                                    <option value="{{$exhibitor->slug}}"
                                        {{$exhibitor->slug == $detail->redirect_to ? 'selected' : ''}}>
                                        {{$exhibitor->title}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Banner title</label>
                                <input class="form-control" type="text" name="banner_title"
                                    value="{{$detail->banner_title}}" placeholder="Enter banner title">
                            </div>
                            <div class="form-group col-md-6">
                                <label>banner image</label>
                                <input id="fileUpload1" class="form-control" value="{{$detail->banner_image}}"
                                    name="banner_image" type="file">
                                <div id="wrapper" class="mt-2">
                                    <div id="image-holder1">
                                        @if($detail->banner_image)
                                        <img src="{{asset('images/main/'. $detail->banner_image)}}"
                                            style="margin-top:12px; margin-bottom:12px;" height="120px" width="120px"
                                            alt="">
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
                                            style="margin-top:12px; margin-bottom:12px;" height="120px" width="120px"
                                            alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')

<script>
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

{{--
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Inner page banner images</div>
            </div>
            <div class="ibox-body" style="">
                <div class="row">

                    <div class="col-sm-6 form-group">
                        <label>blog banner image</label>
                        <input type="file" id="fileUpload5" name="blog_banner_image"
                            value="{{$detail->blog_banner_image}}" class="form-control">
<div id="wrapper" class="mt-2">
    <div id="image-holder5">
        @if($detail->blog_banner_image)
        <img src="{{asset('images/main/'.$detail->blog_banner_image)}}" alt="" class="thumb-image" height="120px"
            width="120px">
        @endif

    </div>
</div>
</div>
<div class="col-sm-6 form-group">
    <label>Team Banner image</label>
    <input type="file" id="fileUpload6" name="team_banner_image" value="{{$detail->team_banner_image}}"
        class="form-control">
    <div id="wrapper" class="mt-2">
        <div id="image-holder6">
            @if($detail->team_banner_image)
            <img src="{{asset('images/main/'.$detail->team_banner_image)}}" alt="" class="thumb-image" height="120px"
                width="120px">
            @endif
        </div>
    </div>
</div>
<div class="col-sm-6 form-group">
    <label>Image gallery banner Image</label>
    <input type="file" id="fileUpload7" name="imagegallery_banner_image" value="{{$detail->imagegallery_banner_image}}"
        class="form-control">
    <div id="wrapper" class="mt-2">
        <div id="image-holder7">
            @if($detail->imagegallery_banner_image)
            <img src="{{asset('images/main/'.$detail->imagegallery_banner_image)}}" alt="" class="thumb-image"
                height="120px" width="120px">
            @endif

        </div>
    </div>
</div>
<div class="col-sm-6 form-group">
    <label>Video gallery banner image</label>
    <input type="file" id="fileUpload8" name="videogallery_banner_image" value="{{$detail->videogallery_banner_image}}"
        class="form-control">
    <div id="wrapper" class="mt-2">
        <div id="image-holder8">
            @if($detail->videogallery_banner_image)
            <img src="{{asset('images/main/'.$detail->videogallery_banner_image)}}" alt="" class="thumb-image"
                height="120px" width="120px">
            @endif

        </div>
    </div>
</div>
<div class="col-sm-6 form-group">
    <label>Contact us banner image</label>
    <input type="file" id="fileUpload9" name="contactus_banner_image" value="{{$detail->contactus_banner_image}}"
        class="form-control">
    <div id="wrapper" class="mt-2">
        <div id="image-holder9">
            @if($detail->contactus_banner_image)
            <img src="{{asset('images/main/'.$detail->contactus_banner_image)}}" alt="" class="thumb-image"
                height="120px" width="120px">
            @endif

        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</div> --}}