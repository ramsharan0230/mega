<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AllStudentsExport implements FromArray, ShouldAutoSize, WithHeadings
{
   /**
    * @return \Illuminate\Support\Collection
    */

   // public function __construct(User $user)
   // {
   //    $this = $user;
   // }

   public function headings(): array
   {
      return [
         'SN',
         'Name',
         'Email',
         'Address',
         'Phone Number',
         'Academic Qualification',
         'Percentage/GPA',
         'Passed Year',
         'Interested Country',
         'Interested Course',
         'Proficiency Test',
      ];
   }
   public function array(): array
   {

      $details = User::latest()->where('publish', 1)->where('role', 'customer')->get();

      $data = [];
      $value = [];
      $i = 1;

      // $details = $details->unique(function ($item) {
      //    return $item['user_id'] . $item['exhibitor_id'];
      // });

      foreach ($details as $detail) {
         $value['sn'] = $i;
         $value['name'] = $detail->name;
         $value['email'] = $detail->email;
         $value['address'] = $detail->address;
         $value['phone'] = $detail->mobile;
         $value['academic_qualification'] = $detail->academic_qualification;
         $value['gpa'] = $detail->gpa;
         $value['passed_year'] = $detail->passed_year;
         $value['interested_country'] = $detail->interested_country;
         $value['interested_course'] = $detail->interested_course;
         $value['proficiency_test'] = $detail->proficiency_test;
         array_push($data, $value);
         $i++;
      }
      return $data;
   }
}
