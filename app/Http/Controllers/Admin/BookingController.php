<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DateTime\DateTimeRepository;
use App\Repositories\Videobooking\VideobookingRepository;

class BookingController extends Controller
{
    public function __construct(VideobookingRepository $model, DateTimeRepository $datetime)
    {
        $this->model = $model;
        $this->datetime = $datetime;
    }
    public function allBookings()
    {
        $details = $this->model->latest()->with(['exhibitor', 'datetime', 'user'])->get();
        return view('admin.booking.list', compact('details'));
    }
    public function edit($id)
    {
        $detail = $this->model->with(['datetime', 'user'])->findOrFail($id);
        return view('admin.booking.edit', compact('detail'));
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
        return redirect()->route('admin.allBookings')->with('message', 'Booking updated successfully');
    }
}
