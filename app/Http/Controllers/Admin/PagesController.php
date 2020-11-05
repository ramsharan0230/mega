<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Str;
use Image;

class PagesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public $readonlyslugpages;

  public function __construct()
  {
    //page slug can not be edited if the page slug is inside this array
    $this->readonlyslugpages = [
      'about-us',
      'message-from-principal',
      'mission-vision',
      'curriculum',
      'exchange-program',
      'admission',
    ];
  }
  public function index()
  {
    $details = Page::orderBy('updated_at', 'desc')->get();

    //to display delete buttom only if user have created the page
    $readonlyslug = $this->readonlyslugpages;
    return view('admin.pages.list', compact('details', 'readonlyslug'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.pages.create');
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
      // 'short_description' => 'required',
      'image' => 'mimes:jpg,jpeg,png,gif|max:3048',
    ]);
    $formInput = $request->except(['image', 'published', 'slug']);
    $formInput['slug'] = $this->generateSlug($request->title, $request->slug, null);
    $formInput['published'] = is_null($request->published) ? 0 : 1;
    if ($request->hasFile('image')) {
      $formInput['image'] = $this->imageProcessing($request->image, 1349, 356, 'no');
    }
    Page::create($formInput);
    return redirect()->route('pages.index')->with('message', 'Page Create Successfuly.');
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
    $detail = Page::findorfail($id);
    //to display delete buttom only if user have created the page
    $readonlyslug = $this->readonlyslugpages;
    return view('admin.pages.edit', compact('detail', 'readonlyslug'));
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
    $oldRecord = Page::findorfail($id);

    $formInput = $request->except(['slug', 'published', 'image']);
    $formInput['slug'] = $this->generateSlug($request->title, $request->slug, $oldRecord);
    $formInput['published'] = is_null($request->published) ? 0 : 1;
    if ($request->hasFile('image')) {
      if ($oldRecord->image) {
        $this->unlinkImage($oldRecord->image);
      }
      $formInput['image'] = $this->imageProcessing($request->image, 1349, 356, 'no');
    }
    $oldRecord->update($formInput);
    return redirect()->route('pages.index')->with('message', 'Page Edited Successfuly.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $record = Page::findorfail($id);
    if ($record->image) {
      $this->unlinkImage($record->image);
    }
    $record->delete();
    return redirect()->route('pages.index')->with('message', 'Page Deleted Successfuly.');
  }

  public function generateSlug($title, $slug, $oldRecord)
  {
    if (is_null($slug))
      $slugReturn = Str::slug($title);
    else
      $slugReturn = Str::slug($slug);

    $count = Page::where('slug', $slugReturn)->count();

    if (!is_null($oldRecord)) {
      if ($oldRecord->slug == $slugReturn) {
        return $slugReturn;
      } else {
        if ($count > 0)
          return $slugReturn . '-' . $count;
        else
          return $slugReturn;
      }
    } else {
      if ($count > 0)
        return $slugReturn . '-' . $count;
      else
        return $slugReturn;
    }
  }

  public function imageProcessing($image, $width, $height, $otherpath)
  {

    $input['imagename'] = Date("D-h-i-s") . '-' . rand() . '-' . '.' . $image->getClientOriginalExtension();
    $thumbPath = public_path('images/thumbnail');
    $mainPath = public_path('images/main');
    $listingPath = public_path('images/listing');

    $img = Image::make($image->getRealPath());
    $img->resize($width, $height)->save($mainPath . '/' . $input['imagename']);

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
    if (file_exists($thumbPath))
      unlink($thumbPath);
    if (file_exists($mainPath))
      unlink($mainPath);
    if (file_exists($listingPath))
      unlink($listingPath);
    return;
  }
}
