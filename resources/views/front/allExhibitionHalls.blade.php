@extends('front.layouts.app')

@php $sameClass=['gold-exhibitor', 'silver-exhibitor']; @endphp


@push('styles')

<link rel="stylesheet" type="text/css" href="/assets/front/css/inner.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<style>
   .submit_primary__button {
      border: none;
      outline: none;
      background: #8bc53f;
      color: #fff;
      padding: 5px 15px;
   }

   .select2-container .select2-selection--single {
      height: 38px;
   }

   .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 38px;
   }
</style>

@endpush
@section('content')

<section class="stall-page all-sec-padding">
   <div class="container">

      <button id="filter_trigger">F <br>i<br>l<br>t<br>e<br>r</button>

      <div class="filter_wrapper">

         @include('include.searchExhibitionTemplate')
      </div>

      <div class="innerpage-title title-wrapper">
         <h2>EXHIBITION HALL</h2>
      </div>
      {{-- category loop starts --}}
      @foreach($dashboard_categories as $category)
      <div class="row">
         <div class="col-12">
            <div class="platinum-wrapper gold-wrapper">
               <h3><span>{{$category->title}}</span></h3>
            </div>
         </div>

         @if($category->slug == 'presenter')
         {{-- exhibitor loop starts --}}
         @foreach($category->exhibitors as $exhibitor1)
         <div class="col-12">
            <div class="top-stall-wrapper">
               @if( isset($visited) && array_key_exists($exhibitor1->slug, $visited))
               <a onclick="return confirm('You have already visited this exhibitor. Would you like to visit again?')"
                  href="{{route('exhibitorDetail',$exhibitor1->slug)}}" class="stall-main-image"><img
                     src="/images/main/{{$exhibitor1->exhibition_hall_image}}" alt="stall"></a>
               <a onclick="return confirm('You have already visited this exhibitor. Would you like to visit again?')"
                  href="{{route('exhibitorDetail',$exhibitor1->slug)}}" class="btn stall-btn">Enter Stall</a>
               @else
               <a href="{{route('exhibitorDetail',$exhibitor1->slug)}}" class="stall-main-image"><img
                     src="/images/main/{{$exhibitor1->exhibition_hall_image}}" alt="stall"></a>
               <a href="{{route('exhibitorDetail',$exhibitor1->slug)}}" class="btn stall-btn">Enter Stall</a>
               @endif

            </div>
         </div>
         {{-- exhibitor loop starts --}}
         @endforeach
         @else
         <div class="col-lg-12 col-md-12 col-12">
            <div
               class="{{ in_array($category->slug, $sameClass) ? 'stall_slider' : $category->slug }} all_stall_wrapper">
               @foreach($category->exhibitors as $exhibitor2)
               <div class="top-stall-wrapper other-stall">
                  @if( isset($visited) && array_key_exists($exhibitor2->slug, $visited))
                  <a onclick="return confirm('You have already visited this exhibitor. Would you like to visit again?')"
                     href="{{route('exhibitorDetail',$exhibitor2->slug)}}" class="stall-main-image"><img
                        src="/images/main/{{$exhibitor2->exhibition_hall_image}}" alt="stall"></a>
                  <a onclick="return confirm('You have already visited this exhibitor. Would you like to visit again?')"
                     href="{{route('exhibitorDetail',$exhibitor2->slug)}}" class="btn stall-btn">Enter Stall</a>
                  @else
                  <a href="{{route('exhibitorDetail',$exhibitor2->slug)}}" class="stall-main-image"><img
                        src="/images/main/{{$exhibitor2->exhibition_hall_image}}" alt="stall"></a>
                  <a href="{{route('exhibitorDetail',$exhibitor2->slug)}}" class="btn stall-btn">Enter Stall</a>
                  @endif

               </div>
               @endforeach
            </div>
         </div>
         @endif

      </div>
      {{-- category loop ends --}}
      @endforeach

   </div>
</section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
   $('#select2').select2();
</script>
@endpush