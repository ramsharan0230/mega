@extends('admin.layouts.app')

@push('styles')
<style media="screen">
    .line {
        width: 100%;
        height: 1px;
        background-color: green;
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
    <form method="post" action="{{route('team.update', $detail->id)}}" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit team</div>

                        <div class="ibox-tools">

                        </div>
                    </div>

                    <div class="ibox-body" style="">

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>Name of person</label>
                                <input class="form-control" name="title" value="{{$detail->title}}" type="text"
                                    placeholder="Enter team Title">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Post</label>
                                <input class="form-control" name="post" value="{{$detail->post}}" type="text"
                                    placeholder="Enter team post">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Short Description</label>
                            <textarea name="short_description" class="form-control" rows="8"
                                cols="80">{{$detail->short_description}}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="8"
                                cols="80">{{$detail->description}}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input class="form-control" id="fileUpload" name="image" type="file">
                            <div id="wrapper" class="mt-2">
                                <div id="image-holder">
                                    @if($detail->image)
                                    <img src="{{asset('images/thumbnail/'. $detail->image)}}"
                                        style="margin-top:12px; margin-bottom:12px;" height="120px" width="120px"
                                        alt="">
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- <div class="check-list">
                            <label class="ui-checkbox ui-checkbox-primary">
                                <input name="publish" type="checkbox" {{$detail->publish == 1 ? 'checked' : ''}}>
                        <span class="input-span"></span>Publish</label>
                    </div> --}}
                    <br>
                    <div class="form-group">
                        <button class="btn btn-default" type="submit">Submit</button>
                    </div>

                </div>
            </div>
        </div>

</div>

</form>
</div>

@endsection

@push('scripts')

@include('admin.layouts._partials.ckeditorsetting')
@include('admin.layouts._partials.imagepreview')

@endpush