<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\Visitor\VisitorRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitorExport;

class VisitorController extends Controller
{

   protected $visitor;
   protected $exhibitor;

   public function __construct(VisitorRepository $visitor, ExhibitorRepository $exhibitor)
   {
      $this->visitor = $visitor;
      $this->exhibitor = $exhibitor;
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($exhibitorId)
   {
      $details = $this->exhibitor->with(['visitors'])->findOrFail($exhibitorId);
      if (auth()->user()->id != $details->user_id) {
         return redirect()->back();
      }
      return view('front.visitor.list', compact('details'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      //
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }

   public function exportVisitor(Request $request)
   {
      return Excel::download(new VisitorExport($request->exhibitor_id), 'visitor.xlsx');
   }
}
