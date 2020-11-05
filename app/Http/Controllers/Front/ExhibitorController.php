<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Exhibitor;
use App\Models\Scholarship;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\DateTime\DateTimeRepository;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\Scholarship\ScholarshipRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Image;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ExhibitorController extends Controller
{
    protected $model = null;

    public function __construct(ExhibitorRepository $model, CategoryRepository $category, UserRepository $user, ScholarshipRepository $scholarship, DateTimeRepository $datetime, CountryRepository $country)
    {
        $this->model = $model;
        $this->category = $category;
        $this->user = $user;
        $this->scholarship = $scholarship;
        $this->datetime = $datetime;
        $this->country = $country;
    }

    /*
    * Exhibitor detail starts
    */

    public function show($id)
    {
        $detail = $this->model->with(['scholarships', 'institutions'])->where('publish', 1)->where('user_id', $id)->firstOrFail();
        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }
        return view('front.exhibitor.show', compact('detail'));
    }

    public function edit_info($id)
    {
        $datas['detail'] = $this->model->where('publish', 1)->where('user_id', $id)->firstOrFail();
        if (auth()->user()->id != $datas['detail']->user_id) {
            return redirect()->back();
        }
        $datas['categories'] = $this->category->where('publish', 1)->latest()->get();
        $datas['districts'] = $this->model->districts;
        $datas['countries'] = $this->country->latest()->where('publish', 1)->get();

        return view('front.exhibitor.edit-info', $datas);
    }

    public function update_info(Request $request, $id)
    {
        $oldRecord = $this->model->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $oldRecord->user_id) {
            return redirect()->back();
        }
        $request->validate([
            'title' => 'required',
            'image' => 'mimes: jpg,jpeg,png,gif|max:3048',
            'exhibition_hall_image' => 'mimes: jpg,jpeg,png,gif|max:3048',
            'logo' => 'max:3048',
            'download' => 'mimetypes:application/pdf|max:10000',
            'category_id' => 'required',
        ]);

        $formInput = $request->except(['publish', 'logo', 'image', 'download', 'exhibition_hall_image', 'countries']);

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $formInput['slug'] = SlugService::createSlug(Exhibitor::class, 'slug', $formInput['title']);

        if ($request->hasFile('image')) {
            if ($oldRecord->image) {
                $this->unlinkImage($oldRecord->image);
            }
            $formInput['image'] = $this->imageProcessing($request->image, 675, 450, 'yes');
        }

        if ($request->logo) {
            if ($oldRecord->logo) {
                $this->unlinkImage($oldRecord->logo);
            }
            $logo = $request->file('logo');
            $imageName = time() . '.logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/main'), $imageName);
            $formInput['logo'] = $imageName;
        }

        if ($request->hasFile('exhibition_hall_image')) {
            if ($oldRecord->exhibition_hall_image) {
                $this->unlinkImage($oldRecord->exhibition_hall_image);
            }
            $formInput['exhibition_hall_image'] = $this->imageProcessing($request->exhibition_hall_image, 660, 370, 'yes');
        }

        if ($request->hasFile('download')) {
            if ($oldRecord->download) {
                $this->unlinkImage($oldRecord->download);
            }
            $documents = $request->file('download');
            $filename = time() . '-' . rand() . '.' . $documents->getClientOriginalExtension();
            $documents->move(public_path('document/'), $filename);
            $formInput['download'] = $filename;
        }

        if ($request->has('countries')) {
            $this->model->update__country_exhibitor_table($id, $request->countries);
        }

        $this->model->update($formInput, $id);

        return redirect()->back()->with('message', 'Data Edited Successfuly.');
    }

    /*
    * Exhibitor detail ends
    */

    /*
    * Scholarship  starts
    */
    public function scholarship_list($id)
    {
        $detail = $this->model->with(['scholarships', 'institutions'])->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }
        return view('front.scholarship.list', compact('detail'));
    }

    public function scholarship_create($id)
    {
        $detail = $this->model->where('publish', 1)->findOrFail($id);

        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }
        return view('front.scholarship.create', compact('detail'));
    }

    public function scholarship_store(Request $request, $id)
    {
        $detail = $this->model->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }
        $request->validate($this->scholarship->rules());

        $formInput = $request->except(['publish', 'image', 'logo']);
        $formInput['slug'] = SlugService::createSlug(Scholarship::class, 'slug', $formInput['title']);

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        if ($request->hasFile('image')) {
            $formInput['image'] = $this->imageProcessing($request->image, 555, 404, 'yes');
        }

        if ($request->logo) {

            $logo = $request->file('logo');
            $imageName = time() . '.logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/main'), $imageName);
            $formInput['logo'] = $imageName;
        }

        $this->scholarship->create($formInput);
        return redirect()->route('front.scholarship.list', $id)->with('message', 'Data created successfully');
    }

    public function scholarship_edit($id)
    {
        $detail = $this->scholarship->with(['exhibitor'])->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $detail->exhibitor->user_id) {
            return redirect()->back();
        }
        return view('front.scholarship.edit', compact('detail'));
    }

    public function scholarship_update(Request $request, $id)
    {
        $detail = $this->model->where('publish', 1)->findOrFail($request->exhibitor_id);

        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }

        $oldRecord = $this->scholarship->where('publish', 1)->findOrFail($id);
        $request->validate($this->scholarship->rules());

        $formInput = $request->except(['publish', 'image', 'logo']);
        $formInput['slug'] = SlugService::createSlug(Scholarship::class, 'slug', $formInput['title']);

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        if ($request->hasFile('image')) {
            if ($oldRecord->image) {
                $this->unlinkImage($oldRecord->image);
            }
            $formInput['image'] = $this->imageProcessing($request->image, 555, 404, 'yes');
        }

        if ($request->logo) {
            if ($oldRecord->logo) {
                $this->unlinkImage($oldRecord->logo);
            }
            $logo = $request->file('logo');
            $imageName = time() . '.logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/main'), $imageName);
            $formInput['logo'] = $imageName;
        }

        $this->scholarship->update($formInput, $id);
        return redirect()->route('front.scholarship.list', $request->exhibitor_id)->with('message', 'Data updated successfully');
    }

    /*
    * Scholarship ends
    */

    /*
    * Datetime starts
    */

    public function datetime_list($id)
    {
        $detail = $this->model->with(['datetimes'])->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }
        return view('front.datetime.list', compact('detail'));
    }

    public function datetime_create($id)
    {
        $detail = $this->model->where('publish', 1)->findOrFail($id);

        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }
        return view('front.datetime.create', compact('detail'));
    }

    public function datetime_store(Request $request, $id)
    {
        $detail = $this->model->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }
        $oldRecord = $this->datetime->where('exhibitor_id', $request->exhibitor_id)->where('date', $request->date)->where('time', $request->time)->first();
        if ($oldRecord) {
            return redirect()->back()->with('error', 'Date and time slot already exists.');
        }

        $formInput = $request->except(['publish']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        $this->datetime->create($formInput);
        return redirect()->route('front.datetime.list', $id)->with('message', 'Data created successfully');
    }

    public function datetime_edit($id)
    {
        $detail = $this->datetime->with(['exhibitor'])->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $detail->exhibitor->user_id) {
            return redirect()->back();
        }
        return view('front.datetime.edit', compact('detail'));
    }

    public function datetime_update(Request $request, $id)
    {
        $detail = $this->model->where('publish', 1)->findOrFail($request->exhibitor_id);

        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }

        $oldRecord = $this->datetime->where('exhibitor_id', $request->exhibitor_id)->where('date', $request->date)->where('time', $request->time)->first();
        if ($oldRecord && $oldRecord->id != $id) {
            return redirect()->back()->with('error', 'Date and time slot already exists.');
        }

        $formInput = $request->except(['publish']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        $this->datetime->update($formInput, $id);

        return redirect()->route('front.datetime.list', $request->exhibitor_id)->with('message', 'Data updated successfully');
    }
    /*
    * Datetime ends
    */

    public function imageProcessing($image, $width, $height, $otherpath)
    {
        $input['imagename'] = Date("D-h-i-s") . '-' . rand() . '-' . '.' . $image->getClientOriginalExtension();
        $thumbPath = public_path('images/thumbnail');
        $mainPath = public_path('images/main');
        $listingPath = public_path('images/listing');

        $img = Image::make($image->getRealPath());
        $img->fit($width, $height)->save($mainPath . '/' . $input['imagename']);

        if ($otherpath == 'yes') {
            $img1 = Image::make($image->getRealPath());
            $img1->resize($width / 2, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($listingPath . '/' . $input['imagename']);

            $img1->fit(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbPath . '/' . $input['imagename']);
            $img1->destroy();
        }

        $img->destroy();
        return $input['imagename'];
    }

    public function unlinkImage($imagename)
    {
        $thumbPath = public_path('images/thumbnail/') . $imagename;
        $mainPath = public_path('images/main/') . $imagename;
        $listingPath = public_path('images/listing/') . $imagename;
        $documentPath = public_path('document/') . $imagename;

        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        if (file_exists($mainPath)) {
            unlink($mainPath);
        }

        if (file_exists($listingPath)) {
            unlink($listingPath);
        }

        if (file_exists($documentPath)) {
            unlink($documentPath);
        }

        return;
    }
}
