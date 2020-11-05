@extends('front.exhibitor.exhibitorMaster')

@section('page_title', 'Create date and time slot')

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
    <form method="post" action="{{route('front.datetime.store', $detail->id)}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Create date & time slot</div>

                        <div class="ibox-tools">

                        </div>
                    </div>

                    <!-- <h3>category Details</h3> -->
                    <div class="ibox-body" style="">

                        <div class="row">

                            <div class="form-group col-md-12">
                                <label>Exhibitor</label>
                                <select name="exhibitor_id" class="form-control">
                                    <option selected value="{{$detail->id}}">{{$detail->title}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Date</label>
                                <input class="form-control" name="date" value="{{old('date')}}" type="date">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Time</label>
                                <input class="form-control" name="time" value="{{old('time')}}" type="time">
                            </div>

                        </div>

                        <div class="check-list">
                            <label class="ui-checkbox ui-checkbox-primary">
                                <input name="publish" type="checkbox" checked>
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