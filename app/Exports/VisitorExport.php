<?php

namespace App\Exports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VisitorExport implements FromArray, ShouldAutoSize, WithHeadings
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
         'Student Name',
         'Student Email',
         'Student Phone Number',
         'Exhibitor Name',
         'Visited Date',
      ];
   }
   public function array(): array
   {

      $details = Visitor::with(['student', 'exhibitor'])->where('exhibitor_id', $this->exhibitorId)->get();

      $data = [];
      $value = [];
      $i = 1;

      // $details = $details->unique(function ($item) {
      //    return $item['user_id'] . $item['exhibitor_id'];
      // });

      foreach ($details as $detail) {
         $value['sn'] = $i;
         $value['name'] = $detail->user_name;
         $value['email'] = $detail->user_email;
         $value['phone'] = $detail->user_phone;
         $value['exhibitor_name'] = $detail->exhibitor_name;
         $value['visited_date'] = \Carbon\Carbon::parse($detail->created_at)->format('Y, M d');
         array_push($data, $value);
         $i++;
      }
      return $data;
   }
}
