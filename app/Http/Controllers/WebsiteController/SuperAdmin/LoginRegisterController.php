<?php

namespace App\Http\Controllers\WebsiteController\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteModels\SuperAdmin\ComponyDetail;
use App\Models\WebsiteModels\SuperAdmin\Credential;
use App\Models\WebsiteModels\SuperAdmin\SystemPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
    {
        $title = SystemPage::where('name', 'login')->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        return view(
            'WebsitePages.SuperAdmin.login',
            [
                "title" => (!empty($title->title)) ? $title->title : 'Login',
                "compony_details" => $compony_details
            ]
        );
    }

    public function index2()
    {
        $title = SystemPage::where('name', 'register')->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        return view(
            'WebsitePages.SuperAdmin.register',
            [
                "title" => (!empty($title->title)) ? $title->title : 'Register',
                "compony_details" => $compony_details
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $rules = [
            "username" => ["required", "min:3", "max:60"],
            "email" => ["required", "unique:credentials,email"],
            "password" => ["required"],
            "confirm_password" => ["required", "same:password"],
            "role" => ["required"],
            "checkbox" => ["required"],
        ];

        if ($request->input('role') == 2) {
            $rules['manager_book'] = ['required'];
        }

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            $CreateUser = new Credential();
            $CreateUser->username = $request['username'];
            $CreateUser->email = $request['email'];
            $CreateUser->password = Hash::make($request['password']);
            $CreateUser->role = $request['role'];
            $CreateUser->manager = (!empty($request['manager_book'])) ? $request['manager_book'] : $request['email'] ;;
            $CreateUser->save();
            if (!$CreateUser) {
                return back()->withErrors(['issue' => 'Failed to register. Please try again.'])->withInput();
            }
            session(["user" => $CreateUser])->regenerate();
            return redirect()->route('dashboard');
        } catch (\Throwable $e) {
            return back()->withErrors(['issue' => $e->getMessage()])->withInput();
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "email" => ["required", "exists:credentials,email", "max:60"],
            "password" => ["required",],
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            $CreateUser = Credential::where("email", $request['email'])->first();
            if ($CreateUser['login_attempts'] >= 3) {
                $lockoutTime = 60;
                $lastAttemptTime = $CreateUser->last_login_attempt_at;
                if ($lastAttemptTime && now()->diffInSeconds($lastAttemptTime) < $lockoutTime) {
                    return back()->withErrors(['issue' => 'Maximum login attempts exceeded. Please try again later.'])->withInput();
                }
            }
            if (!$CreateUser || !Hash::check($request['password'], $CreateUser->password)) {
                $CreateUser->increment('login_attempts');
                $CreateUser->update(['last_login_attempt_at' => now()]);
                return back()->withErrors(['issue' => 'Failed to Login. Email or password not match.'])->withInput();
            }
            $CreateUser->update(['login_attempts' => 0, "last_login_attempt_at" => null]);
            session(["user" => $CreateUser])->regenerate();
            return redirect()->route('dashboard');
        } catch (\Throwable $e) {
            return back()->withErrors(['issue' => $e->getMessage()])->withInput();
        }
    }
}
