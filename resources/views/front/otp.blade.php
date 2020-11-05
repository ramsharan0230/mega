@extends('front.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="/assets/front/css/inner.css">

@endpush

@section('content')
<section class="log-res-page">
   <div class="container">

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
      @if(Session::has('message'))
      <div class="alert alert-success alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         {!! Session::get('message') !!}
      </div>
      @endif
      <div class="log-res-wrapper all-sec-padding">
         <form action="{{route('verifyOTP')}}" class="login-side mx-auto" method="post" autocomplete="off">
            @csrf
            <h3>Enter OTP to proceed</h3>
            <input type="text" name="otp" placeholder="Enter otp" autocomplete="false">
            <button class="btn log-res-btn">Submit</button>
         </form>

      </div>
   </div>
</section>
@endsection

@push('scripts')

@endpush