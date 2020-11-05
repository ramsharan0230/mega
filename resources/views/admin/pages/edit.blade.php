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
    <form method="post" action="{{route('pages.update', $detail->id)}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit Page</div>

                        <div class="ibox-tools">

                        </div>
                    </div>

                    <div class="line"></div>
                    <!-- <h3>Blog Details</h3> -->
                    <div class="ibox-body" style="">

                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control" name="title" value="{{$detail->title}}" type="text"
                                placeholder="Enter Title">
                        </div>


                        <div class="form-group">
                            <label>Slug</label>
                            <input class="form-control" name="slug" value="{{$detail->slug}}" type="text"
                                placeholder="Enter Slug" {{in_array($detail->slug, $readonlyslug) ? 'readonly' : ''}}>
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="8"
                                cols="80">{{$detail->description}}</textarea>
                        </div>

                        <div class="check-list">
                            <label class="ui-checkbox ui-checkbox-primary">
                                <input name="published" type="checkbox" {{$detail->published ? 'checked' : ''}}>
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


    </form>
</div>

@endsection

@push('scripts')
@include('admin.layouts._partials.ckeditorsetting')
@include('admin.layouts._partials.imagepreview')
@endpush