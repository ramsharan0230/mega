<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Academic\AcademicRepository;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    protected $model = null;

    public function __construct(AcademicRepository $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = $this->model->latest()->get();
        return view('admin.academic.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.academic.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $formInput = $request->except(['publish']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        $this->model->create($formInput);
        return redirect()->route('academic.index')->with('message', 'Academic Created Successfuly.');
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
        // return abort(404);
        $detail = $this->model->findOrFail($id);
        return view('admin.academic.edit', compact('detail'));
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
        $request->validate([
            'title' => 'required',
        ]);

        $formInput = $request->except(['publish']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        $this->model->update($formInput, $id);
        return redirect()->route('academic.index')->with('message', 'Academic Edited Successfuly.');
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
        return redirect()->route('academic.index')->with('message', 'Academic Deleted Successfuly.');
    }
}
