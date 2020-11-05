<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Branch\BranchRepository;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class branchController extends Controller
{
    protected $model = null;
    protected $exhibitor = null;
    protected $user = null;

    protected $districts = [
        "achham", "arghakhanchi", "baglung", "baitadi", "bajhang", "bajura", "banke", "bara", "bardiya", "bhaktapur", "bhojpur", "chitwan", "dadeldhura", "dailekh", "dang deukhuri", "darchula", "dhading", "dhankuta", "dhanusa", "dholkha", "dolpa", "doti", "gorkha", "gulmi", "humla", "ilam", "jajarkot", "jhapa", "jumla", "kailali", "kalikot", "kanchanpur", "kapilvastu", "kaski", "kathmandu", "kavrepalanchok", "khotang", "lalitpur", "lamjung", "mahottari", "makwanpur", "manang", "morang", "mugu", "mustang", "myagdi", "nawalpur", "parasi", "nuwakot", "okhaldhunga", "palpa", "panchthar", "parbat", "parsa", "pyuthan", "ramechhap", "rasuwa", "rautahat", "rolpa", "rukum", "rupandehi", "salyan", "sankhuwasabha", "saptari", "sarlahi", "sindhuli", "sindhupalchok", "siraha", "solukhumbu", "sunsari", "surkhet", "syangja", "tanahu", "taplejung", "terhathum", "udayapur"
    ];
    public function __construct(BranchRepository $model, ExhibitorRepository $exhibitor, UserRepository $user)
    {
        $this->model = $model;
        $this->exhibitor = $exhibitor;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = $this->model->with(['exhibitor'])->latest()->get();
        return view('admin.branch.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['exhibitors'] = $this->exhibitor->latest()->where('publish', 1)->get();
        $datas['districts'] = $this->districts;
        // dd($datas['exhibitors']);
        return view('admin.branch.create', $datas);
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

        $formInput = $request->except(['publish']);

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $this->model->create($formInput);

        return redirect()->route('branch.index')->with('message', 'Branch created successfully');
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
        $datas['districts'] = $this->districts;

        return view('admin.branch.edit', $datas);
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
        $request->validate($this->model->rules());

        $formInput = $request->except(['publish']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        $this->model->update($formInput, $id);
        return redirect()->route('branch.index')->with('message', 'Branch updated successfully');
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

        $oldRecord->delete();
        return redirect()->route('branch.index')->with('message', 'Branch Deleted Successfuly.');
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
    //     return redirect()->route('branch.index')->with('message', 'Exhibitor Create Successfuly.');
    // }