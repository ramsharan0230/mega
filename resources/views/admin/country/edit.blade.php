@extends('admin.layouts.app')
@section('page_title', 'Edit country')

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
    <form method="post" action="{{route('country.update', $detail->id)}}" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit interested country</div>
                    </div>
                    <div class="ibox-body" style="">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Interested country name</label>
                                <input class="form-control" name="title" value="{{$detail->title}}" type="text"
                                    placeholder="Enter country Title">
                            </div>
                        </div>

                        <div class="check-list">
                            <label class="ui-checkbox ui-checkbox-primary">
                                <input name="publish" type="checkbox" {{$detail->publish == 1 ? 'checked' : ''}}>
                                <span class="input-span"></span>Publish</label>
                        </div>
                        <br>
                        <div class="form-group">
                            <button class="btn btn-block btn-primary" type="submit">Submit</button>
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

{{-- <div class="form-group">
                            <label>Banner Image</label>
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
</div> --}}