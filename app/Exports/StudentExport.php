<?php

namespace App\Exports;

use App\Models\Videobook;
use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentExport implements FromArray, ShouldAutoSize, WithHeadings
{
   /**
    * @return \Illuminate\Support\Collection
    */
   protected $exhibitorId;

   public function __construct($exhibitorId)
   {
      $this->exhibitorId = $exhibitorId;
   }

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

      $details = Videobook::with(['user'])->where('exhibitor_id', $this->exhibitorId)->get();

      $data = [];
      $value = [];
      $i = 1;

      $details = $details->unique(function ($item) {
         return $item['user_id'] . $item['exhibitor_id'];
      });

      foreach ($details as $detail) {
         $value['sn'] = $i;
         $value['name'] = $detail->user->name;
         $value['email'] = $detail->user->email;
         $value['address'] = $detail->user->address;
         $value['phone'] = $detail->user->mobile;
         $value['academic_qualification'] = $detail->user->academic_qualification;
         $value['gpa'] = $detail->user->gpa;
         $value['passed_year'] = $detail->user->passed_year;
         $value['interested_country'] = $detail->user->interested_country;
         $value['interested_course'] = $detail->user->interested_course;
         $value['proficiency_test'] = $detail->user->proficiency_test;
         array_push($data, $value);
         $i++;
      }
      return $data;
   }
}
