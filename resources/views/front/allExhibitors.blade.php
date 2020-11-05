@extends('front.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="/assets/front/css/inner.css">
@endpush
@section('content')
<section class="exhibitor-section exhibitors-page-wrapper all-sec-padding">
   <div class="container">
      <div class="title-wrapper">
         <h2>Exhibitors:</h2>
      </div>
      @include('front.include.exhibitors')
   </div>
</section>

@endsection

@push('scripts')

@endpush