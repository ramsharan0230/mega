<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\Scholarship\ScholarshipRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Image;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ScholarshipController extends Controller
{
    protected $model = null;

    public function __construct(ScholarshipRepository $model, UserRepository $user, ExhibitorRepository $exhibitor)
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
        }])->latest()->get()->groupBy('type');
        return view('admin.scholarship.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['exhibitors'] = $this->exhibitor->latest()->where('publish', 1)->get();
        // dd($datas['exhibitors']);
        return view('admin.scholarship.create', $datas);
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

        $formInput = $request->except(['publish', 'show_in_home', 'image', 'logo']);
        $formInput['slug'] = SlugService::createSlug(Scholarship::class, 'slug', $formInput['title']);

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $formInput['show_in_home'] = is_null($request->show_in_home) ? 0 : 1;

        if ($request->hasFile('image')) {
            $formInput['image'] = $this->imageProcessing($request->image, 555, 404, 'yes');
        }

        if ($request->logo) {

            $logo = $request->file('logo');
            $imageName = time() . '.logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/main'), $imageName);
            $formInput['logo'] = $imageName;
        }

        $this->model->create($formInput);

        return redirect()->route('scholarship.index')->with('message', 'Data created successfully');
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
        $datas['exhibitors'] = $this->exhibitor->latest()->where('publish', 1)->get();
        $datas['detail'] = $this->model->findOrFail($id);
        return view('admin.scholarship.edit', $datas);
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
        $oldRecord = $this->model->findOrFail($id);
        $request->validate($this->model->rules());

        $formInput = $request->except(['publish', 'show_in_home', 'image', 'logo']);
        $formInput['slug'] = SlugService::createSlug(Scholarship::class, 'slug', $formInput['title']);

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $formInput['show_in_home'] = is_null($request->show_in_home) ? 0 : 1;

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

        $this->model->update($formInput, $id);
        return redirect()->route('scholarship.index')->with('message', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldRecord = $this->model->findOrFail($id);
        if ($oldRecord->image) {
            $this->unlinkImage($oldRecord->image);
        }
        if ($oldRecord->logo) {
            $this->unlinkImage($oldRecord->logo);
        }
        $oldRecord->delete();
        return redirect()->route('scholarship.index')->with('message', 'Data Deleted Successfuly.');
    }

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


// public function generateSlug($title, $slug, $oldRecord)
    // {
    //     if (is_null($slug)) {
    //         $slugReturn = Str::slug($title);
    //     } else {
    //         $slugReturn = Str::slug($slug);
    //     }

    //     $count = $this->model->where('slug', '=', $slugReturn)->count();

    //     if (!is_null($oldRecord)) {
    //         if ($oldRecord->slug == $slugReturn) {
    //             return $slugReturn;
    //         } else {
    //             if ($count > 0) {
    //                 return $slugReturn . '-' . $count;
    //             } else {
    //                 return $slugReturn;
    //             }
    //         }
    //     } else {
    //         if ($count > 0) {
    //             return $slugReturn . '-' . $count;
    //         } else {
    //             return $slugReturn;
    //         }
    //     }
    // }

    // public function store2(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required',
    //         'image' => 'mimes:jpg,jpeg,png,gif|max:3048',
    //     ]);

    //     $formInput = $request->except(['image', 'logo', 'publish', 'slug', 'access', 'password',]);

    //     $formInput['slug'] = SlugService::createSlug(Exhibitor::class, 'slug', $formInput['title']);
    //     $formInput['publish'] = is_null($request->publish) ? 0 : 1;
    //     $formInput['password'] = bcrypt($request->password);
    //     $formInput['access_level'] = '';

    //     if ($request->access) {
    //         $accesses = $request->get('access');
    //         foreach ($accesses as $access) {
    //             $formInput['access_level'] .= ($formInput['access_level'] == "" ? "" : ",") . $access;
    //         }
    //     }

    //     if ($request->hasFile('image')) {
    //         $formInput['image'] = $this->imageProcessing($request->image, 675, 450, 'yes');
    //     }

    //     $this->model->create($formInput);
    //     return redirect()->route('scholarship.index')->with('message', 'Exhibitor Create Successfuly.');
    // }