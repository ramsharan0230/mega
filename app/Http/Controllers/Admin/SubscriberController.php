<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Subscriber\SubscriberRepository;
use Illuminate\Http\Request;
use Mail;

class SubscriberController extends Controller
{
	public function __construct(SubscriberRepository $subscriber)
	{
		$this->subscriber = $subscriber;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$details = $this->subscriber->orderBy('created_at', 'desc')->get();
		return view('admin.subscriber.list', compact('details'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.subscriber.create');
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
			'email' => 'required|unique:subscribers,email',
		]);
		$formData = $request->except('publish', 'send');
		$formData['publish'] = is_null($request->publish) ? 0 : 1;
		// $formData['send'] = is_null($request->send) ? 0 : 1;
		$this->subscriber->create($formData);
		return redirect()->route('subscriber.index')->with('message', 'Subscriber created successfully.');
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
		$detail = $this->subscriber->find($id);
		return view('admin.subscriber.edit', compact('detail'));
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
			'email' => 'unique:subscribers,email,' . $id,
		]);

		$formData = $request->except('publish', 'send');
		$formData['publish'] = is_null($request->publish) ? 0 : 1;
		// $formData['send'] = is_null($request->send) ? 0 : 1;
		$this->subscriber->update($formData, $id);
		return redirect()->route('subscriber.index')->with('message', 'Subscriber updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$this->subscriber->destroy($id);
		return redirect()->back()->with('message', 'Subscriber deleted successfully');
	}
}
