<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Branch\BranchRepository;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class branchController extends Controller
{
    protected $model = null;
    protected $branch = null;
    protected $user = null;
    protected $districts = [
        "achham", "arghakhanchi", "baglung", "baitadi", "bajhang", "bajura", "banke", "bara", "bardiya", "bhaktapur", "bhojpur", "chitwan", "dadeldhura", "dailekh", "dang deukhuri", "darchula", "dhading", "dhankuta", "dhanusa", "dholkha", "dolpa", "doti", "gorkha", "gulmi", "humla", "ilam", "jajarkot", "jhapa", "jumla", "kailali", "kalikot", "kanchanpur", "kapilvastu", "kaski", "kathmandu", "kavrepalanchok", "khotang", "lalitpur", "lamjung", "mahottari", "makwanpur", "manang", "morang", "mugu", "mustang", "myagdi", "nawalpur", "parasi", "nuwakot", "okhaldhunga", "palpa", "panchthar", "parbat", "parsa", "pyuthan", "ramechhap", "rasuwa", "rautahat", "rolpa", "rukum", "rupandehi", "salyan", "sankhuwasabha", "saptari", "sarlahi", "sindhuli", "sindhupalchok", "siraha", "solukhumbu", "sunsari", "surkhet", "syangja", "tanahu", "taplejung", "terhathum", "udayapur"
    ];
    public function __construct(ExhibitorRepository $model, BranchRepository $branch, UserRepository $user)
    {
        $this->model = $model;
        $this->branch = $branch;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $details = $this->model->with(['branches'])->latest()->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $details->user_id) {
            return redirect()->back();
        }
        return view('front.branch.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $datas['detail'] = $detail = $this->model->where('publish', 1)->findOrFail($id);

        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }

        $datas['districts'] = $this->districts;
        // dd($datas['exhibitors']);
        return view('front.branch.create', $datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $id)
    {
        $detail = $this->model->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }
        $request->validate($this->branch->rules());

        $formInput = $request->except(['publish']);

        $formInput['publish'] = is_null($request->publish) ? 0 : 1;
        $this->branch->create($formInput);

        return redirect()->route('front.branch.index', $id)->with('message', 'Branch created successfully');
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
    public function edit($exhibitorId, $id)
    {
        $datas['detail'] = $detail = $this->branch->with(['exhibitor'])->where('publish', 1)->findOrFail($id);
        if (auth()->user()->id != $detail->exhibitor->user_id) {
            return redirect()->back();
        }
        $datas['districts'] = $this->districts;
        $datas['exhibitor_id'] = $exhibitorId;
        return view('front.branch.edit', $datas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $exhibitorId, $id)
    {
        $detail = $this->model->where('publish', 1)->findOrFail($request->exhibitor_id);

        if (auth()->user()->id != $detail->user_id) {
            return redirect()->back();
        }

        $request->validate($this->branch->rules());

        $formInput = $request->except(['publish']);
        $formInput['publish'] = is_null($request->publish) ? 0 : 1;

        $this->branch->update($formInput, $id);
        return redirect()->route('front.branch.index', $request->exhibitor_id)->with('message', 'Branch updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($exhibitorId, $id)
    {
        $oldRecord = $this->branch->findOrFail($id);

        $oldRecord->delete();
        return redirect()->back()->with('message', 'Branch Deleted Successfuly.');
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