<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use Image;

class SettingController extends Controller
{
    public function index()
    {
        $detail = Dashboard::first();
        return view('admin.setting', compact('detail'));
    }

    public function update(Request $request, $id)
    {
        $record = Dashboard::findOrFail($id);

        $request->validate($this->rules(), $this->messages());
        $formInput = $request->except(['logo', 'banner_image']);

        if ($request->logo) {
            if ($record->logo) {
                $this->unlinkImage($record->logo);
            }
            $logo = $request->file('logo');
            $imageName = time() . '.logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/main'), $imageName);
            $formInput['logo'] = $imageName;
        }

        if ($request->hasFile('banner_image')) {
            if ($record->banner_image) {
                $this->unlinkImage($record->banner_image);
            }
            $formInput['banner_image'] = $this->imageProcessing($request->file('banner_image'), 1370, 500, 'no');
        }

        $record->update($formInput);
        return redirect()->route('setting')->with('message', 'Setting updated Successfully');
    }

    public function rules()
    {
        $rules = [
            'site_name' => 'required',
            'logo' => 'max:3048',
            'banner_image' => 'mimes:jpg,jpeg,png,gif|max:3048',
            // 'contactus_image' => 'dimensions:max_width=2000,max_height=2000|mimes:jpg,jpeg,png,gif|max:3048',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            // 'contactus_image.dimensions' => 'Upto 2000 * 2000 size is allowed',

        ];
    }

    public function imageProcessing($image, $width, $height, $otherpath)
    {

        $input['imagename'] = Date("D-h-i-s") . '-' . rand() . '-' . '.' . $image->getClientOriginalExtension();
        $thumbPath = public_path('images/thumbnail');
        $mainPath = public_path('images/main');
        $listingPath = public_path('images/listing');

        $img = Image::make($image->getRealPath());
        $img->fit($width, $height)->save($mainPath . '/' . $input['imagename']);

        // with no fit
        // $img->save($mainPath . '/' . $input['imagename']);

        if ($otherpath == 'yes') {
            $img->fit($width / 2, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($listingPath . '/' . $input['imagename']);

            $img->fit(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbPath . '/' . $input['imagename']);
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
