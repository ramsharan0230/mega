<div class="row">
   <div class="col-md-12">
      <div class="ibox">
         <div class="ibox-head">
            <div class="ibox-title">Edit profile</div>
            @if(auth()->user() && auth()->user()->role == 'customer' )
            <div class="ibox-title">
               <a href="{{ route('allExhibitionHalls') }}" class="btn btn-primary">Back To Exhibition Hall</a>
            </div>
            @endif
         </div>

         <div class="ibox-body" style="">
            <div class="row">
               <div class="form-group col-md-6">
                  <label>Email</label>
                  <input class="form-control" name="email" value="{{$detail->email}}" type="text" required>
               </div>
               <div class="form-group col-md-6">
                  <label>Full name</label>
                  <input class="form-control" name="name" value="{{$detail->name}}" type="text" required>
               </div>
               <div class="form-group col-md-6">
                  <label>Password</label>
                  <input class="form-control" name="password" type="password" placeholder="Enter password">
               </div>
               <div class="form-group col-md-6">
                  <label>Re Password</label>
                  <input class="form-control" name="password_confirmation" type="password" placeholder="Enter Password">
               </div>
               <div class="form-group col-md-6">
                  <label>Address</label>
                  <input class="form-control" name="address" value="{{$detail->address}}" type="text" required>
               </div>
               <div id="adminApp" class="col-md-6">
                  <label>Mobile number</label>
                  <div class="form-row">
                     <div class="form-group col-3">
                        <select name="country_code" id="" class="form-control">
                           <option v-for="(country,i) in countries" :value="country.code"
                              :selected="country.code == country_code">
                              @{{country.code}}
                           </option>
                        </select>
                     </div>
                     <div class="col">
                        <input name="mobile" value="{{$detail->mobile}}" type="text" required class="form-control"
                           placeholder="Mobile No">
                     </div>
                  </div>
               </div>
               <div class="form-group col-md-6">
                  <label>Academic Qualification</label>
                  <select name="academic_qualification" class="form-control">
                     <option value></option>
                     @foreach($dashboard_academics as $academic)
                     <option value="{{$academic->id}}"
                        {{ $detail->academic_qualification == $academic->id ? 'selected' : '' }}>
                        {{$academic->title}}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group col-md-6">
                  <label>Percent/GPA</label>
                  <input class="form-control" name="gpa" value="{{$detail->gpa}}" type="text" required>
               </div>
               <div class="form-group col-md-6">
                  <label>Passed Year</label>
                  <input type="text" name="passed_year" class="yearpicker form-control">
               </div>
               <div class="form-group col-md-6">
                  <label>Interested Country</label>
                  <select name="interested_country" class="form-control" required>
                     <option value>Select one</option>
                     @foreach($dashboard_allCountries as $country)
                     <option {{ $country->id == $detail->interested_country  ? 'selected' : ''}}
                        value="{{$country->id}}">{{$country->title}}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group col-md-6">
                  <label>Interested course</label>
                  <input class="form-control" name="interested_course" value="{{$detail->interested_course}}"
                     type="text" required>
               </div>
               <div class="form-group col-md-6">
                  <label>Attended any of the following English Proficiency Tests?</label>
                  <select name="proficiency_test" id="" class="form-control">
                     <option value></option>
                     @foreach($dashboard_proficiens as $proficien)
                     <option value="{{$proficien->id}}"
                        {{ $detail->proficiency_test == $proficien->id ? 'selected' : '' }}>
                        {{$proficien->title}}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group col-md-6">
                  <label>How did you know about us ?</label>
                  <select name="know_about" id="" class="form-control">
                     <option value>-- Please select one --</option>
                     <option {{$detail->know_about == 'Friends' ? 'selected' : ''}} value="Friends">Friends</option>
                     <option {{$detail->know_about == 'Social Media' ? 'selected' : ''}} value="Social Media">Social
                        Media</option>
                     <option {{$detail->know_about == 'SMS' ? 'selected' : ''}} value="SMS">SMS</option>
                     <option {{$detail->know_about == 'Email' ? 'selected' : ''}} value="Email">Email</option>
                     <option {{$detail->know_about == 'Others' ? 'selected' : ''}} value="Others">Others</option>
                  </select>
               </div>
               @if(auth()->user() && auth()->user()->role == 'super-admin' )
               <div class="check-list col-md-12">
                  <label class="ui-checkbox ui-checkbox-primary">
                     <input name="publish" type="checkbox" {{ $detail->publish ? 'checked': ''}}>
                     <span class="input-span"></span>Publish</label>
               </div>
               @endif

            </div>

            <br>
            <div class="form-group">
               <button class="btn btn-primary btn-block" type="submit">Submit</button>
            </div>

         </div>
      </div>
   </div>

</div>

{{-- @if($detail->type == 'guide')
               <div class="form-group col-md-6">
                  <label>Redirect to</label>
                  <select name="redirect_to" class="form-control">
                     <option value>-- select one --</option>
                     @foreach($exhibitors as $exhibitor)
                     <option value="{{$exhibitor->slug}}"
{{$exhibitor->slug == $detail->redirect_to ? 'selected' : ''}}>{{$exhibitor->title}}
</option>
@endforeach
</select>
</div>
@endif --}}