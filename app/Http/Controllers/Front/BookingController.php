<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DateTime\DateTimeRepository;
use App\Repositories\Videobooking\VideobookingRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;
use App\Repositories\Exhibitor\ExhibitorRepository;

class BookingController extends Controller
{
    public function __construct(VideobookingRepository $model, DateTimeRepository $datetime, ExhibitorRepository $exhibitor)
    {
        $this->model = $model;
        $this->datetime = $datetime;
        $this->exhibitor = $exhibitor;
    }
    public function index()
    {
        $details = $this->model->latest()->with(['exhibitor', 'datetime', 'user'])->where('exhibitor_id', auth()->user()->exhibitor->id)->get();
        return view('front.booking.list', compact('details'));
    }
    public function edit($id)
    {
        $detail = $this->model->with(['datetime', 'user'])->findOrFail($id);
        return view('front.booking.edit', compact('detail'));
    }
    public function update(Request $request, $id)
    {
        $detail = $this->model->findOrFail($id);
        $datetime = $this->datetime->findOrFail($detail->datetime_id);
        $formData = $request->except(['isBooked']);
        if (is_null($request->isBooked)) {
            $formData['isBooked'] = 0;
        } else {
            $formData['isBooked'] = 1;
            $datetime->isAvailable = 0;
            $datetime->save();
        }
        $detail->update($formData);
        return redirect()->route('front.booking.index')->with('message', 'Booking updated successfully');
    }

    public function studentExport(Request $request)
    {
        $detail = $this->exhibitor->where('user_id', $request->user_id)->firstOrFail();
        return Excel::download(new StudentExport($detail->id), 'student.xlsx');
    }
}
