<?php  date_default_timezone_set("Asia/Kathmandu"); ?>

<!DOCTYPE html>
<html>

<head>
   <title>Visit Exhibitors</title>
   <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap"
      rel="stylesheet">
</head>
<style>

</style>

<body>
   <div style="border:5px solid red; padding: 15px; border-radius: 10px; max-width: 500px; background-color: #c2d5c2;
			font-family: 'Open Sans', sans-serif;
			margin: 0 auto;">
      <table style="width: 100%;">
         <thead>
            <tr>
               <th style="width: 20%; "><img src="{{asset('images/main/'.$dashboard_composer->logo)}}" alt="Mega"
                     style="width: 70px; height: auto;"></th>
               <th
                  style="font-size: 25px; color: darkblue; font-weight: 600; text-shadow: 0px 1px 2px darkblue; border-bottom: 1px solid darkblue; width: 80%;">
                  Mega
               </th>
            </tr>
         </thead>

      </table>
      <div>
         <p>Dear {{auth()->user()->name}}, <br> </p>
         You have visited:
         @foreach($visits as $key => $visit)
         <p><strong>{{$visit['exhibitor_name']}}</strong></p>
         @endforeach
         <br>
         <p> Regards,</p>
         <p>Mega Admin</p>
      </div>

   </div>

</body>

</html>