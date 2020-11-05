@foreach($dashboard_categories as $category)
<div class="platinum-wrapper {{ $category->slug != 'presenter' ? 'gold-wrapper': null}}">
   <h3><span>{{$category->title}}:</span></h3>
   @if($category->slug == 'presenter')
   @foreach($category->exhibitors as $exhibitor)
   <a id="{{$category->slug}}" href="{{route('exhibitorDetail', $exhibitor->slug)}}" class="exhibitor-logo"><img
         src="/images/main/{{$exhibitor->logo}}" alt="image"></a>
   @endforeach

   @else
   <ul class="gold-exhibitor-list" id="{{$category->slug}}">
      @foreach($category->exhibitors()->where('publish', 1)->inRandomOrder()->get() as $exhibitor2)
      <li><a href="{{route('exhibitorDetail', $exhibitor2->slug)}}"><img src="/images/main/{{$exhibitor2->logo}}"
               alt="image"></a></li>
      @endforeach
   </ul>
   @endif
</div>
@endforeach