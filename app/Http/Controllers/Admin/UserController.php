<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\User\UserRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllStudentsExport;
use App\Repositories\Country\CountryRepository;
use App\User;
use Image;

class UserController extends Controller
{

    private $user;
    public $access_options = array(
        'user' => 'Admin User',
        'exhibitor' => 'Exhibitor',
        'datetime' => 'Date Time Slot',
        'scholarship' => 'Scholarship',
        'branch' => 'Branch',
        'subscriber' => 'Subscriber',
        'year' => 'Passed Year',
        'academic' => 'Academic Qualification',
        'proficiency' => 'Proficiency Tests',
    );
    public function __construct(UserRepository $user, ExhibitorRepository $exhibitor, CountryRepository $interestedCountry)
    {
        $this->user = $user;
        $this->exhibitor = $exhibitor;
        $this->interestedCountry = $interestedCountry;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = $this->user->latest()->where('role', '=', 'admin')->get();
        return view('admin.user.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $access_options = $this->access_options;
        return view('admin.user.create', compact('access_options'));
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
            'image' => 'mimes: jpg,jpeg,png,gif|max:3048',
            'logo' => 'mimetypes:image/png,image/jpeg,image/jpg,image/svg|max:3048',
        ];

        $message = ['access.required' => "please select atleast one role",];
        $this->validate($request, $rules, $message);

        $formInput = $request->except('publish', 'password_confirmation', 'access', 'image', 'logo');

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $formInput['password'] = bcrypt($request->password);
        $formInput['access_level'] = '';

        if ($request->access) {
            $accesses = $request->get('access');
            foreach ($accesses as $access) {
                $formInput['access_level'] .= ($formInput['access_level'] == "" ? "" : ",") . $access;
            }
        }

        if ($request->hasFile('image')) {
            // [$width, $height] = getimagesize($request->file('logo')->getRealPath());
            $formInput['image'] = $this->imageProcessing($request->image, 675, 450, 'yes');
        }

        if ($request->hasFile('logo')) {
            [$width, $height] = getimagesize($request->file('logo')->getRealPath());
            $formInput['logo'] = $this->imageProcessing($request->file('logo'), $width, $height, 'no');
        }

        $this->user->create($formInput);
        return redirect()->route('user.index')->with('message', 'User added successfully.');
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
        $access_options = $this->access_options;

        $detail = $this->user->find($id);
        $oldAccesses = ($detail->access_level) ? explode(",", $detail->access_level) : array();

        return view('admin.user.edit', compact('detail', 'access_options', 'oldAccesses'));
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
        $old = $this->user->find($id);

        $sameEmailVal = $old->email == $request->email ? true : false;
        $message = ['access.required' => "please select atleast one role"];

        $this->validate($request, $this->rules($old->id, $sameEmailVal), $message);

        $formInput = $request->except('publish', 'access', 'image', 'password', 'logo', 'password_confirmation');

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $formInput['access_level'] = '';

        if ($request->password) {
            $formInput['password'] = bcrypt($request->password);
        }

        if ($request->access) {
            $accesses = $request->get('access');
            foreach ($accesses as $access) {
                $formInput['access_level'] .= ($formInput['access_level'] == "" ? "" : ",") . $access;
            }
        }

        if ($request->hasFile('image')) {
            if ($old->image) {
                $this->unlinkImage($old->image);
            }
            $formInput['image'] = $this->imageProcessing($request->image, 675, 450, 'yes');
        }

        if ($request->hasFile('logo')) {
            if ($old->logo) {
                $this->unlinkImage($old->logo);
            }
            [$width, $height] = getimagesize($request->file('logo')->getRealPath());
            $formInput['logo'] = $this->imageProcessing($request->file('logo'), $width, $height, 'no');
        }

        $this->user->update($formInput, $id);
        return redirect()->route('user.index')->with('message', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->destroy($id);
        return redirect()->back()->with('message', 'User Deleted Successfully');
    }
    public function rules($oldId = null, $sameEmailVal = false)
    {
        $rules =  [
            'email' => 'unique:users|email',
            'image' => 'mimes:jpg,png,jpeg,gif|max:3048',
            'logo' => 'mimetypes:image/png,image/jpeg,image/jpg,image/svg|max:3048',
            'access' => 'required',
            'password' => 'confirmed',
        ];
        if ($sameEmailVal) {
            $rules['email'] = 'unique:users,email,' . $oldId . '|max:255';
        }
        return $rules;
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

    public function allCustomers()
    {
        $details = $this->user->latest()->where('role', '=', 'customer')->get();
        return view('admin.customer.list', compact('details'));
    }

    public function customerEdit($id)
    {
        $detail = $this->user->latest()->where('role', '=', 'customer')->findOrFail($id);
        $exhibitors = $this->exhibitor->latest()->where('publish', 1)->get();
        return view('admin.customer.edit', compact('detail', 'exhibitors'));
    }

    public function customerUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|confirmed|min:7',
            'mobile' => 'required|numeric|digits:10',
        ]);
        $formData = $request->except('password', 'publish');

        if ($request->password) {
            $formData['password'] = bcrypt($request->password);
        }

        if (is_null($request->publish)) {
            $formData['publish'] = 0;
        } else {
            $formData['activation_link'] = null;
            $formData['publish']     = 1;
        }

        $this->user->update($formData, $id);
        return redirect()->back()->with('message', 'Profile updated successfully');
    }

    public function exportAllStudents()
    {
        return Excel::download(new AllStudentsExport(), 'allstudent.xlsx');
    }
}
