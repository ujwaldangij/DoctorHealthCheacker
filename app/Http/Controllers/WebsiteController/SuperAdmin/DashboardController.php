<?php

namespace App\Http\Controllers\WebsiteController\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteModels\SuperAdmin\ComponyDetail;
use App\Models\WebsiteModels\SuperAdmin\Credential;
use App\Models\WebsiteModels\SuperAdmin\doctor;
use App\Models\WebsiteModels\SuperAdmin\menu;
use App\Models\WebsiteModels\SuperAdmin\Notification as SuperAdminNotification;
use App\Models\WebsiteModels\SuperAdmin\schedule;
use App\Models\WebsiteModels\SuperAdmin\SystemPage;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = SystemPage::where('name', 'dashboard')->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        $menu2 = new menu();
        $user =  session('user')->role;
        if ($user  == 2) {
            $menu = menu::whereIn('id',[1,2,3,4])->get();
        }elseif ($user  == 3 or $user == 4) {
            $menu = menu::whereIn('id',[2])->get();
        }else {
            $menu = new menu();
        }
        $notifications = SuperAdminNotification::all();
        $dr_count = doctor::count();
        if (session('user')->role == 1 or session('user')->role == 3) {
            $k = DB::select('SELECT *,schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id');
            $schedule_count = count($k);
        }else{
            $k = DB::select('SELECT *,schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id WHERE schedule.user_id = '.session('user')->id);
            $schedule_count = count($k);
        }
        if (session('user')->role == 1 or session('user')->role == 3) {
            $agreeCount = Doctor::where('agree_disagree', 'agree')->count();
        }else{
            $agreeCount = Doctor::where('agree_disagree', 'agree')
                    ->where('session_user_id', session('user')->id)
                    ->count();
        }
        if (session('user')->role == 1 or session('user')->role == 3) {
            $disagreeCount = Doctor::where('agree_disagree', 'disagree')->count();
        }else{
            $disagreeCount = Doctor::where('agree_disagree', 'disagree')
                        ->where('session_user_id', session('user')->id)
                        ->count();
        }
        if (session('user')->role == 1 || session('user')->role == 3) {
            $less = DB::table('schedule')
                    ->where('result', '<', 25)
                    ->whereNotNull('result') // Exclude null values
                    ->where('result', '!=', '') // Exclude empty values
                    ->count();
        } else {
            $less = DB::table('schedule')
                    ->where('result', '<', 25)
                    ->where('user_id', session('user')->id)
                    ->whereNotNull('result') // Exclude null values
                    ->where('result', '!=', '') // Exclude empty values
                    ->count();
        }
        if (session('user')->role == 1 or session('user')->role == 3) {
            $more = DB::table('schedule')
                    ->where('result','>=', '25')
                    ->count();
        }else{
            $more = DB::table('schedule')
                        ->where('result','>=', '25')
                        ->where('user_id', session('user')->id)
                        ->count();
        }
        return view(
            'WebsitePages.SuperAdmin.dashboard',
            [
                "title" => (!empty($title->title)) ? $title->title : 'Dashboard',
                "compony_details" => $compony_details,
                "menu" => $menu->all(),
                "sub_menu" => $menu2->getMenuWithSubmenus(),
                'notifications' => $notifications,
                'dr_count' => $dr_count,
                'schedule_count' => $schedule_count,
                'agreeCount' => $agreeCount,
                'disagreeCount' => $disagreeCount,
                'less' => $less,
                'more' => $more,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // auth()->user();
        // dd(session('user')->email);
        $invoice['name'] = "invoice";
        $invoice['message'] = "invoice invoice invoice invoice invoice";
        $user = Credential::where('id',4)->first();
        $user->notify(new InvoicePaid($invoice));
        dd('done');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markedAsRead(Request $request, $id)
    {
        $marked = SuperAdminNotification::where('id',$id)->update(['read_at' => now()]);
        if ($marked) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
