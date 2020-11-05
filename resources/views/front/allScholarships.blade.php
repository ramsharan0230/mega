@extends('front.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="/assets/front/css/inner.css">
@endpush
@section('content')
<section class="scholorship-page all-sec-padding">
   <div class="container">
      <div class="title-wrapper scholarship-title">
         <h2>SCHOLARSHIPS</h2>
      </div>
      @if($scholarships->isNotEmpty())
      @foreach($scholarships as $scholarship)
      <div class="row block-first-row scholarship-page-wrapper">
         <div class="col-lg-6 col-md-12 col-12">
            <div class="four-block-image">
               <img src="/images/main/{{$scholarship->image}}" alt="block-image">
            </div>
         </div>
         <div class="col-lg-6 col-md-12 col-12 pl-0">
            <div class="block-content">
               <img src="/images/main/{{$scholarship->logo}}" alt="university-image">
               <p>{{$scholarship->percent}}% Scholarship Available</p>
               <a class="btn" href="{{route('scholarshipDetail',$scholarship->id)}}" tabindex="-1">Apply Now</a>
            </div>
         </div>
      </div>
      @endforeach
      @else
      <p class="bg-danger p-3 text-white">No scholarships found</p>
      @endif
   </div>
</section>

@endsection