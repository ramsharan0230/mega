@extends('admin.layouts.app')
@section('page_title', 'Edit booking')

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
   <form method="post" action="{{route('booking.update', $detail->id)}}" enctype="multipart/form-data">
      @csrf
      @method('put')
      <input type="hidden" name="exhibitor_id" value="{{$detail->exhibitor_id}}">

      <div class="row">
         <div class="col-md-12">
            <div class="ibox">
               <div class="ibox-head">
                  <div class="ibox-title">Edit booking</div>
               </div>
               <div class="ibox-body" style="">
                  <div class="row">
                     <div class="form-group col-md-12">
                        <label>Client</label>
                        <input class="form-control" name="text" name="user_id" disabled value="{{$detail->user->name}}"
                           type="text">
                     </div>
                     <div class="form-group col-md-12">
                        <label>Date</label>
                        <input class="form-control" name="date" value="{{$detail->date}}" type="text">
                     </div>
                     <div class="form-group col-md-12">
                        <label>Time</label>
                        <input class="form-control" name="time" value="{{$detail->datetime->time}}" type="text">
                     </div>
                  </div>

                  <div class="check-list">
                     <label class="ui-checkbox ui-checkbox-primary">
                        <input name="isBooked" type="checkbox" {{$detail->isBooked == 1 ? 'checked' : ''}}>
                        <span class="input-span"></span>Confirm Booking</label>
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