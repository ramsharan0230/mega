<div class="here">
   <select class="select__time" name="datetime_id" id="">
      <option value>Time</option>
      @foreach($datetimes as $time)
      <option value="{{$time->id}}">{{$time->time}}</option>
      @endforeach
   </select>
</div>