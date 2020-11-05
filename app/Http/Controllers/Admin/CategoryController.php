<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use Image;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CategoryController extends Controller
{
    protected $model = null;

    public function __construct(CategoryRepository $model)
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
        return view('admin.category.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
        return view('admin.category.create');
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
            'image' => 'mimes:jpg,jpeg,png,gif|max:3048',
        ]);

        $formInput = $request->except(['image', 'publish', 'slug']);
        $formInput['slug'] = SlugService::createSlug(Category::class, 'slug', $formInput['title']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        if ($request->hasFile('image')) {
            $formInput['image'] = $this->imageProcessing($request->image, 750, 562, 'yes');
        }

        $this->model->create($formInput);
        return redirect()->route('category.index')->with('message', 'Category Create Successfuly.');
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
        return view('admin.category.edit', compact('detail'));
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
            'image' => 'mimes:jpg,png,jpeg,gif|max:3048',
        ]);

        $oldRecord = $this->model->findOrFail($id);

        $formInput = $request->except(['slug', 'publish', 'image']);
        $formInput['slug'] = SlugService::createSlug(Category::class, 'slug', $formInput['title']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        if ($request->hasFile('image')) {
            if ($oldRecord->image) {
                $this->unlinkImage($oldRecord->image);
            }
            $formInput['image'] = $this->imageProcessing($request->image, 750, 562, 'yes');
        }
        $this->model->update($formInput, $id);
        return redirect()->route('category.index')->with('message', 'Category Edited Successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = $this->model->findOrFail($id);
        if ($record->image) {
            $this->unlinkImage($record->image);
        }
        $this->model->destroy($id);
        return redirect()->route('category.index')->with('message', 'Category Deleted Successfuly.');
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
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        if (file_exists($mainPath)) {
            unlink($mainPath);
        }

        if (file_exists($listingPath)) {
            unlink($listingPath);
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