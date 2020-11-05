<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use App\Repositories\DateTime\DateTimeRepository;
use App\Repositories\User\UserRepository;
use App\Models\Visitor;
use App\Repositories\Country\CountryRepository;
use App\User;
use Session;
use Auth;
use Mail;

class CustomerController extends Controller
{
    protected $districts = [
        "achham", "arghakhanchi", "baglung", "baitadi", "bajhang", "bajura", "banke", "bara", "bardiya", "bhaktapur", "bhojpur", "chitwan", "dadeldhura", "dailekh", "dang deukhuri", "darchula", "dhading", "dhankuta", "dhanusa", "dholkha", "dolpa", "doti", "gorkha", "gulmi", "humla", "ilam", "jajarkot", "jhapa", "jumla", "kailali", "kalikot", "kanchanpur", "kapilvastu", "kaski", "kathmandu", "kavrepalanchok", "khotang", "lalitpur", "lamjung", "mahottari", "makwanpur", "manang", "morang", "mugu", "mustang", "myagdi", "nawalpur", "parasi", "nuwakot", "okhaldhunga", "palpa", "panchthar", "parbat", "parsa", "pyuthan", "ramechhap", "rasuwa", "rautahat", "rolpa", "rukum", "rupandehi", "salyan", "sankhuwasabha", "saptari", "sarlahi", "sindhuli", "sindhupalchok", "siraha", "solukhumbu", "sunsari", "surkhet", "syangja", "tanahu", "taplejung", "terhathum", "udayapur"
    ];

    protected $visitor;
    protected $interestedCountry;

    public function __construct(UserRepository $user, DateTimeRepository $datetime, Dashboard $setting, Visitor $visitor, CountryRepository $interestedCountry)
    {
        $this->user = $user;
        $this->setting = $setting;
        $this->datetime = $datetime;
        $this->visitor = $visitor;
        $this->interestedCountry = $interestedCountry;
    }
    public function loginRegister()
    {
        $districts = $this->districts;
        return view('front.loginRegister', compact('districts'));
    }

    public function logout()
    {
        $visits = session('__visited');

        if (isset($visits) && !empty($visits)) {

            $this->visitor->insert($visits);
            $datas = [
                'visits' => $visits,
            ];

            Mail::send('email.visitEmail', $datas, function ($message) {
                $message->to(auth()->user()->email)->from('info@mega.com');
                $message->subject('Site visited');
            });
        }

        Auth::logout();
        Session::flush();

        return redirect()->route('home');
    }

    public function exhibitorLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('exhibitorLogin');
    }

    /*
    * Customer Related functions
    **/

    public function customerRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:7',
            'mobile' => 'required|numeric|digits:10|unique:users',
        ]);
        $formData = $request->except('password');
        $formData['publish'] = 0;
        $formData['role'] = 'customer';
        $formData['password'] = bcrypt($request->password);
        $formData['activation_link'] = \Str::random(63);
        $formData['otp'] = mt_rand(100000, 999999);
        $data = $this->user->create($formData);
        if ($data) {
            $mail_data = [
                'name' => $request->name,
                'password' => $request->password,
                'email' => $request->email,
                'activation_link' => $data->activation_link,
            ];

            $userName = 'inimates';
            $password = 'nepal123$';
            $message = $formData['otp'] . ' is your verification code for registration. Do not share this code with anyone. Thank you.';
            $destination = $request->mobile; //9999999999
            $sender = 'OneUp';
            $url = 'http://api.ininepal.com/api/index?';

            $urlQuery = http_build_query([
                'username' => $userName,
                'password' => $password,
                'destination' => $destination,
                'message' => $message,
                'sender' => $sender
            ]);
            $url_final = $url . $urlQuery;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url_final);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            Mail::send('email.account-activation-mail', $mail_data, function ($message) use ($mail_data) {
                $message->to($mail_data['email'])->from('info@mega.com');
                $message->subject('Account activation link ' . route('home'));
            });
            return redirect()->route('getOTPLogin')->with('message', 'Please enter OTP code. You can also verify your account using activation link sent in your email.');
        } else {
            return redirect()->back()->with('message', 'Sorry There was a problem while creating your account.');
        }
        return redirect()->route('getOTPLogin');
    }

    public function customerLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $result = User::where('email', $request->email)->where('role', 'customer')->first();

        if ($result) {
            if (!\Hash::check($request->password, $result->password)) {
                return back()->with('message', 'Invalid Username\Password');
            } elseif ($result->role != 'admin' && $result->publish == 0) {
                return back()->with('message', "Your account is inactive!<br> Please contact  Team.");
            } elseif ($result->role != 'exhibitor' && $result->publish == 0) {
                return back()->with('message', "Your account is inactive!<br> Please contact  Team.");
            } else {
                if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
                    if (auth()->user()->type == 'guide' && $this->setting->first()->redirect_to) {
                        return redirect()->route('exhibitorDetail', $this->setting->first()->redirect_to);
                    }
                    return redirect()->route('allExhibitionHalls');
                } else {
                    return back()->withInput()->withErrors(['email' => 'something is wrong!']);
                }
            }
        }
        return back()->with('message', 'Invalid Username\Password');
    }

    public function VerifyNewAccount($token, Request $request)
    {
        if ($token) {
            $length = strlen($token);

            if ($length < 63) {
                $request->session()->flash('error', 'Invalid Activation link found.');
                return redirect()->route('loginRegister');
            }

            $user = $this->user->where('activation_link', $token)->first();

            if (!$user) {
                $request->session()->flash('message', 'Sorry!  No information found for this user request.');
                return redirect()->route('loginRegister');
            }
            if ($user->activation_link == $token) {
                $user['activation_link'] = null;
                $user['publish']     = 1;
            } else {
                $request->session()->flash('message', 'Invalid Activation link found.');
                return redirect()->route('loginRegister');
            }
            $user_info = [
                'email' => $user->email,
                'name' => $user->name,
            ];

            // dd($data);
            $success  = $user->save();

            if ($success) {
                Mail::send('email.verification-success', $user_info, function ($message) use ($user_info) {
                    $message->to($user_info['email'])->from('info@mega.com');
                    $message->subject('Account activated successfully ' . route('home'));
                });

                $request->session()->flash('message', 'Thank You ! Your Account Has been Activated. You can login your account now.');
            } else {
                $request->session()->flash('message', 'Sorry There was a problem while activating your  account. Please try again.');
            }
            return redirect()->route('loginRegister');
        } else {
            $request->session()->flash('error', 'Invalid Request.');
            return redirect()->route('loginRegister');
        }
    }

    public function getOTPLogin()
    {
        return view('front.otp');
    }

    public function verifyOTP(Request $request)
    {
        $token = $request->otp;
        if ($token) {
            $length = strlen($token);

            if ($length < 6) {
                $request->session()->flash('error', 'Invalid OTP.');
                return redirect()->route('loginRegister');
            }

            $user = $this->user->where('otp', $token)->first();

            if (!$user) {
                $request->session()->flash('message', 'Sorry!  No information found for this user request.');
                return redirect()->route('loginRegister');
            }
            if ($user->otp == $token) {
                $user['otp'] = null;
                $user['publish']     = 1;
            } else {
                $request->session()->flash('message', 'Invalid OTP.');
                return redirect()->route('loginRegister');
            }
            $user_info = [
                'email' => $user->email,
                'name' => $user->name,
            ];

            // dd($data);
            $success  = $user->save();

            if ($success) {
                Mail::send('email.verification-success', $user_info, function ($message) use ($user_info) {
                    $message->to($user_info['email'])->from('info@mega.com');
                    $message->subject('Account activated successfully ' . route('home'));
                });

                $request->session()->flash('message', 'Thank You ! Your Account Has been Activated. You can login your account now.');
            } else {
                $request->session()->flash('message', 'Sorry There was a problem while activating your  account. Please try again.');
            }
            return redirect()->route('loginRegister');
        } else {
            $request->session()->flash('error', 'Invalid Request.');
            return redirect()->route('loginRegister');
        }
    }

    public function customerDashboard()
    {
        return view('front.customer.customerDashboard');
    }

    public function customerProfile()
    {
        $detail = auth()->user();
        return view('front.customer.customerProfile', compact('detail'));
    }

    public function customerProfileUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|confirmed|min:7',
            'mobile' => 'required|numeric|digits:10|unique:users,mobile,' . $id,
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
    /*
    * Customer Related functions
    **/

    /*
    * Exhibitor Related functions
    **/

    public function exhibitorLogin()
    {
        return view('front.exhibitor.login');
    }

    public function exhibitorPostLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $result = User::where('email', $request->email)->where('role', 'exhibitor')->first();

        if ($result) {
            if (!\Hash::check($request->password, $result->password)) {
                return back()->with('message', 'Invalid Username\Password');
            } elseif ($result->role != 'exhibitor' && $result->publish == 0) {
                return back()->with('message', "Your account is inactive!<br> Please contact  Team.");
            } else {
                if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
                    return redirect()->route('front.exhibitor.show', $result->id);
                } else {
                    return back()->withInput()->withErrors(['email' => 'something is wrong!']);
                }
            }
        }
        return back()->with('message', 'Invalid Username\Password');
    }

    public function exhibitorDashboard()
    {
        return view('front.exhibitor.exhibitorDashboard');
    }

    /*
    * Exhibitor Related functions
    **/

    public function get__time_by_date(Request $request)
    {
        $query = $this->datetime->latest()->where('exhibitor_id', $request->exhibitor_id)->where('publish', 1)->where('isAvailable', 1)->select('id', 'time');
        if ($request->date == date('Y-m-d')) {
            $query = $query->where('date', date('Y-m-d'))->where('time', '>', date('H:i'));
        } else {
            $query = $query->where('date', $request->date);
        }

        $datetimes = $query->get();
        return response()->json([
            'html' => view('front.include.getTimeByDate', compact('datetimes'))->render()
        ], 200);
    }
}
