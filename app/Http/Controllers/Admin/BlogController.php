<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = Blog::orderBy('updated_at', 'desc')->get();
        return view('admin.blog.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.create');
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
            'description' => 'required',

            'image' => 'mimes:jpg,jpeg,png,gif|max:3048',
        ]);

        $formInput = $request->except(['image', 'publish', 'slug']);
        $formInput['slug'] = $this->generateSlug($request->title, $request->slug, null);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        if ($request->hasFile('image')) {
            $formInput['image'] = $this->imageProcessing($request->image, 750, 562, 'yes');
        }
        Blog::create($formInput);
        return redirect()->route('blog.index')->with('message', 'Blog Create Successfuly.');
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
        $detail = Blog::findorfail($id);
        return view('admin.blog.edit', compact('detail'));
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
            'description' => 'required',
            'image' => 'mimes:jpg,png,jpeg,gif|max:3048',
        ]);
        $oldRecord = Blog::findorfail($id);

        $formInput = $request->except(['slug', 'publish', 'image']);
        $formInput['slug'] = $this->generateSlug($request->title, $request->slug, $oldRecord);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        if ($request->hasFile('image')) {
            if ($oldRecord->image) {
                $this->unlinkImage($oldRecord->image);
            }
            $formInput['image'] = $this->imageProcessing($request->image, 750, 562, 'yes');
        }
        $oldRecord->update($formInput);
        return redirect()->route('blog.index')->with('message', 'Blog Edited Successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Blog::findorfail($id);
        if ($record->image) {
            $this->unlinkImage($record->image);
        }
        $record->delete();
        return redirect()->route('blog.index')->with('message', 'Blog Deleted Successfuly.');
    }

    public function generateSlug($title, $slug, $oldRecord)
    {
        if (is_null($slug)) {
            $slugReturn = Str::slug($title);
        } else {
            $slugReturn = Str::slug($slug);
        }

        $count = Blog::where('slug', $slugReturn)->count();

        if (!is_null($oldRecord)) {
            if ($oldRecord->slug == $slugReturn) {
                return $slugReturn;
            } else {
                if ($count > 0) {
                    return $slugReturn . '-' . $count;
                } else {
                    return $slugReturn;
                }
            }
        } else {
            if ($count > 0) {
                return $slugReturn . '-' . $count;
            } else {
                return $slugReturn;
            }
        }
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
