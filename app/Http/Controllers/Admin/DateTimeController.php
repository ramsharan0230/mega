<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DateTime\DateTimeRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Exhibitor\ExhibitorRepository;

use Illuminate\Http\Request;

class DateTimeController extends Controller
{
    protected $model = null;

    public function __construct(DateTimeRepository $model, UserRepository $user, ExhibitorRepository $exhibitor)
    {
        $this->model = $model;
        $this->user = $user;
        $this->exhibitor = $exhibitor;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = $this->model->with(['exhibitor' => function ($query) {
            $query->with(['exhibitor_user' => function ($query) {
                $query->where('publish', 1);
            }]);
        }])->latest()->get();
        return view('admin.datetime.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['exhibitors'] = $this->exhibitor->latest()->where('publish', 1)->get();

        return view('admin.datetime.create', $datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->model->rules());
        $oldRecord = $this->model->where('exhibitor_id', $request->exhibitor_id)->where('date', $request->date)->where('time', $request->time)->first();
        if ($oldRecord) {
            return redirect()->back()->with('error', 'Date and time slot already exists.');
        }

        $formInput = $request->except(['publish', 'isAvailable']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $formInput['isAvailable'] = is_null($request->isAvailable) ? 0 : 1;

        $this->model->create($formInput);
        return redirect()->route('datetime.index')->with('message', 'Time added successfuly.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['detail'] = $this->model->findOrFail($id);
        $datas['exhibitors'] = $this->exhibitor->latest()->where('publish', 1)->get();

        return view('admin.datetime.edit', $datas);
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
        $request->validate($this->model->rules());

        $oldRecord = $this->model->where('exhibitor_id', $request->exhibitor_id)->where('date', $request->date)->where('time', $request->time)->first();
        if ($oldRecord && $oldRecord->id != $id) {
            return redirect()->back()->with('error', 'Date and time slot already exists.');
        }

        $formInput = $request->except(['publish', 'isAvailable']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        if (is_null($request->isAvailable)) {
            $formInput['isAvailable'] = 0;
            $oldRecord->video_book()->update(['isBooked' => 0]);
        } else {
            $formInput['isAvailable'] = 1;
        }
        $this->model->update($formInput, $id);
        return redirect()->route('datetime.index')->with('message', 'Time Edited Successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model->destroy($id);
        return redirect()->route('datetime.index')->with('message', 'Time Deleted Successfuly.');
    }
}
