<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exhibitor;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Image;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ExhibitorController extends Controller
{

    protected $model = null;
    public $access_options = [
        'exhibitor-show' => 'View',
        'exhibitor-edit' => 'Edit Infos',
    ];
    public $message = ['access.required' => "please select atleast one role"];

    public function __construct(ExhibitorRepository $model, CategoryRepository $category, UserRepository $user, CountryRepository $country)
    {
        $this->model = $model;
        $this->category = $category;
        $this->user = $user;
        $this->country = $country;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->latest()->with(['exhibitor' => function ($query) {
            $query->with(['category', 'countries']);
        }])->where('role', '=', 'exhibitor')->get();

        return view('admin.exhibitor.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $access_options = $this->access_options;
        $categories = $this->category->where('publish', 1)->latest()->get();
        $districts = $this->model->districts;
        $countries = $this->country->where('publish', 1)->get();
        // $users = $this->user->latest()->where('publish', 1)->where('role', 'exhibitor')->get();
        return view('admin.exhibitor.create', compact('access_options', 'categories', 'districts', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'unique:users|email',
            'password' => 'required|confirmed|min:7',
            'access' => 'required',
        ];

        $message = ['access.required' => "please select atleast one role",];
        $this->validate($request, $rules, $message);

        $value = $request->except('publish', 'password_confirmation', 'access');

        $value['publish'] = is_null($request->publish) ? 0 : 1;
        $value['password'] = bcrypt($request->password);
        $value['access_level'] = '';

        if ($request->access) {
            $accesses = $request->get('access');
            foreach ($accesses as $access) {
                $value['access_level'] .= ($value['access_level'] == "" ? "" : ",") . $access;
            }
        }

        $created_exhibitor = $this->user->create($value);
        if (!$created_exhibitor) {
            return redirect()->back()->with('message', 'Exhibitor created successfully');
        }
        $this->model->create(['user_id' => $created_exhibitor->id]);
        return redirect()->route('exhibitor.edit_info', $created_exhibitor->id)->with('message', 'Exhibitor created successfully');
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
        $detail_id = $id;
        $access_options = $this->access_options;
        $detail = $this->user->findOrFail($id);
        $oldAccesses = ($detail->access_level) ? explode(",", $detail->access_level) : [];
        $districts = $this->model->districts;
        $countries = $this->country->where('publish', 1)->get();
        return view('admin.exhibitor.edit', compact('detail', 'access_options', 'oldAccesses', 'detail_id', 'categories', 'districts', 'countries'));
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
        $oldRecord = $this->user->findOrFail($id);

        $formInput = $request->except(['image', 'publish', 'logo', 'access', 'password']);

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $formInput['access_level'] = '';

        if ($request->access) {
            $accesses = $request->get('access');
            foreach ($accesses as $access) {
                $formInput['access_level'] .= ($formInput['access_level'] == "" ? "" : ",") . $access;
            }
        }

        if ($request->password) {
            $formInput['password'] = bcrypt($request->password);
        }

        $this->user->update($formInput, $id);
        return redirect()->route('exhibitor.index')->with('message', 'Exhibitor Edited Successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->findOrFail($id)->delete();
        $oldRecord = $this->model->where('user_id', $id)->firstOrFail();
        if ($oldRecord->image) {
            $this->unlinkImage($oldRecord->image);
        }
        if ($oldRecord->logo) {
            $this->unlinkImage($oldRecord->logo);
        }
        $oldRecord->delete();
        return redirect()->route('exhibitor.index')->with('message', 'Exhibitor Deleted Successfuly.');
    }

    public function edit_info($id)
    {
        $datas['detail'] = $this->model->where('user_id', $id)->firstOrFail();
        $datas['categories'] = $this->category->where('publish', 1)->latest()->get();
        $datas['countries'] = $this->country->latest()->where('publish', 1)->get();
        $datas['districts'] = $this->model->districts;
        return view('admin.exhibitor.edit-info', $datas);
    }

    public function update_info(Request $request, $id)
    {
        $oldRecord = $this->model->findOrFail($id);

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
        return redirect()->route('exhibitor.index')->with('message', 'Exhibitor Edited Successfuly.');
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
    //     return redirect()->route('exhibitor.index')->with('message', 'Exhibitor Create Successfuly.');
    // }