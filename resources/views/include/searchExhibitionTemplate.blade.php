<form action="{{route('searchExhibition')}}" method="GET" id="filter_form" class="my-4">
   <span class="close-btn">X</span>
   @csrf
   <div class="form-row justify-content-center">
      <div class="form-group col-md-12">
         <select name="country" class="form-control">
            <option value>-- Interested country --</option>
            @foreach($dashboard_allCountries as $country)
            <option value="{{$country->id}}">{{$country->title}}</option>
            @endforeach
         </select>
      </div>

      <div class="form-group col-md-12">
         <select name="district" class="form-control" id="select2">
            <option value>-- Select district --</option>
            <option value>All</option>
            @if(auth()->user() && auth()->user()->role == 'customer')
            <option value="{{auth()->user()->district}}">On My Location</option>
            @endif
            @foreach($districts as $district)
            <option value="{{$district}}">{{ucfirst($district)}}</option>
            @endforeach
         </select>
      </div>

      <div class="form-group col-md-12">
         <button class="submit_primary__button">Submit</button>
      </div>
   </div>
</form>