@extends('front.layouts.app')

@push('styles')
<style>
   div#frontErrorMessage,
   div#frontSuccessMessage {
      position: absolute;
      top: 30%;
      right: 30%;
   }
</style>
@endpush

@section('content')
@if($dashboard_composer->banner_image)
<!-- main banner section starts -->
<section class="main-banner-section" style="background-image:url(/images/main/{{$dashboard_composer->banner_image}})">
   <div class="container">
      <div class="main-banner-content">
         <h1>{{$dashboard_composer->banner_title}}</h1>
         <div class="button-wrapper">
            <a class="btn" href="{{route('allExhibitionHalls')}}">Enter Now</a>
            <a class="btn" type="button" data-toggle="modal" data-target="#myModal">Guide Me</a>
         </div>
      </div>
   </div>
</section>

@if (count($errors) > 0)
<div class="alert alert-danger message" id="frontErrorMessage">
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
@if(session('message'))
<div class="alert alert-success alert-dismissible message" id="frontSuccessMessage">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
   </button>
   {{session('message')}}
</div>
@endif
<!-- main banner section ends -->
@endif
<!-- four block section starts -->
@if($scholarships->isNotEmpty() || $institutions->isNotEmpty())
<section class="four-block-section all-sec-padding">
   <div class="container">
      <div class="block-slider">
         @foreach($scholarships as $scholarship)
         <div class="slider-container">
            <div class="row block-first-row">
               <div class="col-lg-6 col-md-12 col-12">
                  <div class="four-block-image">
                     <img src="/images/main/{{$scholarship->image}}" alt="block-image">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12 col-12 pl-0">
                  <div class="block-content">
                     <img src="/images/main/{{$scholarship->logo}}" alt="university-image">
                     <p>{{$scholarship->percent}}% Scholarship Available</p>
                     <a class="btn" href="{{route('scholarshipDetail',$scholarship->id)}}">Apply Now</a>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
      </div>

      <div class="block-two">
         @foreach($institutions->chunk(2) as $institution)
         <div class="block-container">
            <div class="row">
               @foreach($institution as $institute)
               <div class="col-lg-6 col-md-12 col-12">
                  <a href="{{route('institutionDetail',$institute->id)}}"
                     class="block-image-width-text four-block-image">
                     <img src="/images/main/{{$institute->image}}" alt="image">
                     <div class="block-image-content">
                        <h3>{{$institute->title}}</h3>
                        <span class="btn">Know More</span>
                     </div>
                  </a>
               </div>
               @endforeach
            </div>
         </div>
         @endforeach
      </div>
   </div>
</section>
@endif
<!-- four block section ends -->

@if($dashboard_categories->isNotEmpty())
<section class="exhibitor-section all-sec-padding">
   <div class="container">
      <div class="title-wrapper">
         <h2>Exhibitors:</h2>
      </div>
      @include('front.include.exhibitors')
   </div>
</section>
@endif

<!-- subscribe-section starts -->
<section class="subscribe-section all-sec-padding">
   <div class="container">
      <div class="title-wrapper subscribe-title">
         <h2>STAY CONNECTED</h2>
         <span>Get the Latest Study Abroad Updates:</span>
      </div>

      <form action="{{route('saveSubscriber')}}" class="subscription-form" method="POST">
         @csrf
         <input type="email" placeholder="Enter your email address" name="email">
         <button class="btn">Subscribe</button>
      </form>
   </div>
</section>
<!-- subscription section ends -->

<!-- oneup section starts -->
<section class="oneup-section">
   <div class="container">
      <div class="oneup-wrapper platinum-wrapper">
         <h3>Event of:</h3>
         <a href="#" class="event-logo"><img src="/assets/front/img/oneup.svg" alt="image"></a>
      </div>
   </div>
</section>
<!-- oneup section ends -->

@endsection

@push('scripts')
<script>
   $("#frontSuccessMessage").delay(2000).slideUp(500);
   $("#frontErrorMessage").delay(2000).slideUp(500);
</script>


@endpush