<select name="academic_qualification" id="" class="selectpicker">
   <option value>Academic Qualification</option>
   @foreach($dashboard_academics as $academic)
   <option value="{{$academic->id}}">{{$academic->title}}</option>
   @endforeach
</select>
<div class="input-select-wrapper">
   <input name="gpa" type="text" required placeholder="Percentage/GPA" value="{{old('gpa')}}">
   <input type="text" name="passed_year" placeholder="Passed year" class="yearpicker">
</div>
<div class="input-select-wrapper">
   <select name="interested_country" id="" class="selectpicker">
      <option value>Interested Country</option>
      @foreach($dashboard_allCountries as $country)
      <option value="{{$country->id}}">{{$country->title}}</option>
      @endforeach
   </select>
   <input name="interested_course" type="text" required placeholder="Interested Course">
</div>
<select name="proficiency_test" id="" class="selectpicker">
   <option value>Attended any of the following English Proficiency Tests?</option>
   @foreach($dashboard_proficiens as $proficien)
   <option value="{{$proficien->id}}">{{$proficien->title}}</option>
   @endforeach
</select>
<select name="know_about" id="" class="selectpicker">
   <option value>How did you know about us ?</option>
   <option value="Friends">Friends</option>
   <option value="Social Media">Social Media</option>
   <option value="SMS">SMS</option>
   <option value="Email">Email</option>
   <option value="Others">Others</option>
</select>