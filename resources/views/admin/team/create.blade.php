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
    <form method="post" action="{{route('team.store')}}" enctype="multipart/form-data">
        @csrf


        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Create team</div>

                        <div class="ibox-tools">

                        </div>
                    </div>

                    <!-- <h3>team Details</h3> -->
                    <div class="ibox-body" style="">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Name of person</label>
                                <input class="form-control" name="title" value="{{old('title')}}" type="text"
                                    placeholder="Enter team Title">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Post</label>
                                <input class="form-control" name="post" value="{{old('post')}}" type="text"
                                    placeholder="Enter team post">
                            </div>

                        </div>


                        <div class="form-group">
                            <label>Short Description</label>
                            <textarea name="short_description" class="form-control" rows="8"
                                cols="80">{{old('short_description')}}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="8"
                                cols="80">{{old('description')}}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input id="fileUpload" class="form-control" value="{{old('image')}}" name="image"
                                type="file">
                            <div id="wrapper" class="mt-2">
                                <div id="image-holder">
                                </div>
                            </div>
                        </div>

                        {{-- <div class="check-list">
                            <label class="ui-checkbox ui-checkbox-primary">
                                <input name="publish" type="checkbox" checked>
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