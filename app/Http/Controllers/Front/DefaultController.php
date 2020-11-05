<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Videobook;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\Refer\ReferRepository;
use App\Repositories\Scholarship\ScholarshipRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Subscriber\SubscriberRepository;
use Mail;
use Session;
use App\Models\Message;
use App\Repositories\Visitor\VisitorRepository;

class DefaultController extends Controller
{
    protected $refer;
    protected $visitor;

    public function __construct(ScholarshipRepository $scholarship, CategoryRepository $category, SubscriberRepository $subscriber, Page $page, UserRepository $user, ExhibitorRepository $exhibitor, ReferRepository $refer, VisitorRepository $visitor)
    {
        $this->scholarship = $scholarship;
        $this->subscriber = $subscriber;
        $this->category = $category;
        $this->page = $page;
        $this->scholarship = $scholarship;
        $this->user = $user;
        $this->exhibitor = $exhibitor;
        $this->refer = $refer;
        $this->visitor = $visitor;
    }

    public function index()
    {
        $datas['scholarships'] = $this->scholarship->latest()->where('show_in_home', 1)->where('type', 'scholarship')->where('publish', 1)->get();
        $datas['institutions'] = $this->scholarship->latest()->where('show_in_home', 1)->where('type', 'institution')->where('publish', 1)->get();
        return view('front.index', $datas);
    }

    public function allExhibitors()
    {
        return view('front.allExhibitors');
    }

    public function allScholarships()
    {
        $datas['scholarships'] = $this->scholarship->latest()->where('type', 'scholarship')->where('publish', 1)->get();
        return view('front.allScholarships', $datas);
    }

    public function exhibitorDetail($slug)
    {
        if (!auth()->user() || (auth()->user()->role != 'customer')) {
            return redirect()->route('loginRegister');
        }

        $detail = $this->exhibitor->with(['scholarships', 'institutions', 'exhibitor_user', 'branches'])->where('slug', $slug)->firstOrFail();

        $detail['view_count'] += 1;
        // $detail->save();

        $visited = session('__visited');

        if (empty($visited)) {
            $visited[$detail->slug] = [
                'user_id' => auth()->user()->id,
                'user_email' => auth()->user()->email,
                'user_name' => auth()->user()->name,
                'user_phone' => auth()->user()->mobile,
                'exhibitor_name' => $detail->title,
                'exhibitor_id' => $detail->id,
                'count' => 1,
            ];
            session()->put('__visited', $visited);

            return view('front.exhibitorDetail', compact('detail'));
        } elseif (!isset($visited[$detail->slug])) {
            // When new exhibitorDetail page is visited keep that in session as well
            $visited[$detail->slug] = [
                'user_id' => auth()->user()->id,
                'user_email' => auth()->user()->email,
                'user_name' => auth()->user()->name,
                'user_phone' => auth()->user()->mobile,
                'exhibitor_name' => $detail->title,
                'exhibitor_id' => $detail->id,
                'count' => 1,
            ];
            session()->put('__visited', $visited);
            return view('front.exhibitorDetail', compact('detail'));
        } else {
            // if that exhibitorDetail page exists in session
            $visited[$detail->slug] = [
                'user_id' => auth()->user()->id,
                'user_email' => auth()->user()->email,
                'user_name' => auth()->user()->name,
                'user_phone' => auth()->user()->mobile,
                'exhibitor_name' => $detail->title,
                'exhibitor_id' => $detail->id,
                'count' => $visited[$detail->slug]['count'] + 1,
            ];
            session()->put('__visited', $visited);
            return view('front.exhibitorDetail', compact('detail'));
        }
    }

    public function institutionDetail($id)
    {
        $detail = $this->scholarship->where('type', 'institution')->where('publish', 1)->findOrFail($id);
        $exhibitor = $this->exhibitor->findOrFail($detail->exhibitor_id);
        return redirect()->route('exhibitorDetail', $exhibitor->slug);
    }

    public function scholarshipDetail($id)
    {
        $detail = $this->scholarship->where('type', 'scholarship')->where('publish', 1)->findOrFail($id);
        $exhibitor = $this->exhibitor->findOrFail($detail->exhibitor_id);
        return redirect()->route('exhibitorDetail', $exhibitor->slug);
    }

    public function allExhibitionHalls(Request $request)
    {
        $districts = $this->exhibitor->districts;
        $visited = session('__visited');
        return view('front.allExhibitionHalls', compact('districts', 'visited'));
    }

    public function searchExhibition(Request $request)
    {
        $datas['districts'] = $this->exhibitor->districts;

        $datas['presenter'] = $this->category->with(['exhibitors'])->find(4);
        $datas['association'] = $this->category->with(['exhibitors'])->find(5);

        $datas['details'] = $details = $this->exhibitor
            ->with(['category'])
            ->where('publish', 1)
            ->where(function ($query) use ($request) {
                if (isset($request->country)) {
                    $query->where('country', $request->country);
                }
                if (isset($request->district)) {
                    $query->where('district', $request->district);
                }
            })
            ->get();

        $datas['country'] = $request->country;
        $datas['req_district'] = $request->district;
        $datas['address'] = $request->address;

        // dd($details);

        return view('front.searchExhibition', $datas);
    }

    public function dynamicPages($slug)
    {
        $detail = $this->page->where('slug', $slug)->where('published', 1)->firstOrFail();
        $relatedBlogs = $this->blog->latest()->where('publish', 1)->get();
        return view('front.pages.automatic', compact('detail', 'relatedBlogs'));
    }

    public function saveSubscriber(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:subscribers,email',
        ]);
        $formData = $request->all();
        $formData['publish'] = 1;

        $this->subscriber->create($formData);

        Mail::send('email.subscriptionReceiveTemplate', $formData, function ($message) use ($formData) {
            $message->to($formData['email'])->from('info@mega.com');
            $message->subject('Subscription');
        });

        return redirect()->back()->with('message', 'Thankyou for subscribing.');
    }

    public function video__booking(Request $request)
    {
        $formData = $request->except(['_token']);
        $formData['user_id'] = auth()->user()->id;
        $formData['isBooked'] = 0;
        Videobook::create($formData);
        return redirect()->back()->with('message', 'Video request send successfully');
    }
    public function addRefer(Request $request)
    {
        $request->validate([
            'refer_email' => 'required',
        ], ['refer_email.required' => 'Please fill the required information.']);
        $data = $request->except(['_token', 'exhibitor_name', 'refer__option']);
        // $slug = $this->exhibitor->find($request->exhibitor_id)->slug;

        $mailData = [
            'refer_email' => $request->refer_email,
            'exhibitor_url' => $request->exhibitor_url,
            'exhibitor_name' => $request->exhibitor_name,
            'sender_email'   => auth()->user()->email,
        ];
        if ($request->refer__option == 'Email') {
            Mail::send('email.referTemplate', $mailData, function ($message) use ($mailData) {
                $message->to($mailData['refer_email'])->from($mailData['sender_email']);
                $message->subject('Refer a friend');
            });
        } else if ($request->refer__option == 'SMS') {
            $userName = 'inimates';
            $password = 'nepal123$';
            $message = $mailData['exhibitor_name'] . ' is organizing online education fair. Please click: ' . $mailData['exhibitor_url'];
            $destination = $request->refer_email;
            $sender = 'OneUp';
            $url = 'http://api.ininepal.com/api/index?';
            // $url_string = "username={$userName}&password={$password}&destination={$destination}&message={$message}&sender={$sender}";
            $urlQuery = http_build_query([
                'username' => $userName,
                'password' => $password,
                'destination' => $destination,
                'message' => $message,
                'sender' => $sender
            ]);
            $url_final = $url . $urlQuery;
            // dd($url_final);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url_final);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $response = explode(':', $response);
            curl_close($ch);
            if ($response[0] != '1701') {
                return redirect()->back()->with('refer', 'SMS cannot be sent at the moment');
            }
        }

        $this->refer->create($data);

        return redirect()->back()->with('refer', 'Refer sent successfully');
    }
}

// Mail::send('email.contactTemplate', $data, function ($message) use ($data, $request) {
//     $message->to('iabhiyaan@gmail.com')->from($data['email'], $data['name']);
//     $message->subject($data['subject']);
// });

// public function blogList()
//     {
//         try {
//             $details = $this->blog->latest()->where('publish', 1)->get();
//             if (is_null($details)) {
// abort('404');
//             } else {
//                 return view('front.blog.list', compact('details'));
//             }
//         } catch (\Exception $e) {
// abort('404');
//         }
//     }

//     public function blogInner($slug)
//     {
//         try {
//             $detail = $this->blog->latest()->where('publish', 1)->where('slug', $slug)->first();

//             $relatedBlogs = $this->blog->latest()->where('publish', 1)->where('slug', '!=', $slug)->inRandomOrder()->take(5)->get();

//             return view('front.blog.details', compact('detail', 'relatedBlogs'));
//         } catch (\Exception $e) {
// abort('404');
//         }
//     }

// $datas['details'] = $details = $this->user
//             ->with(['exhibitor' => function ($query) {
//                 $query->with(['category' => function ($query) {
//                     $query->whereNotIn('id', [4, 5]);
//                 }]);
//             }])
//             ->where('role', 'exhibitor')
//             // ->join('branches', 'users.id', '=', 'branches.user_id')
//             ->where(function ($query) use ($request) {
//                 if (isset($request->address)) {
//                     $query->where('address', 'like', '%' . $request->address . '%');
//                 }
//                 if (isset($request->country)) {
//                     $query->where('country', $request->country);
//                 }
//                 if (isset($request->district)) {
//                     $query->where('district', $request->district);
//                 }
//                 if (isset($request->branch)) {
//                     $query->orWhere('branches.address', $request->branch);
//                 }
//             })
//             ->get();

        // dd($details);