<?php

namespace App\Http\Controllers\WebsiteController\SuperAdmin;

use Log;
use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\WebsiteModels\SuperAdmin\menu;
use App\Models\WebsiteModels\SuperAdmin\track;
use Illuminate\Support\Facades\Log as FacadesLog;
use App\Models\WebsiteModels\SuperAdmin\Credential;
use App\Models\WebsiteModels\SuperAdmin\SystemPage;
use App\Models\WebsiteModels\SuperAdmin\ComponyDetail;
use App\Models\WebsiteModels\SuperAdmin\schedule as sud;
use App\Models\WebsiteModels\SuperAdmin\doctor as SuperAdminDoctor;
use App\Models\WebsiteModels\SuperAdmin\schedule as SuperAdminSchedule;
use App\Models\WebsiteModels\SuperAdmin\Notification as SuperAdminNotification;

class schedule extends Controller
{
    //
    public function schedule()
    {
        $title = SystemPage::where('name', 'schedule')->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        $menu2 = new menu();
        $user =  session('user')->role;
        if ($user  == 2) {
            $menu = menu::whereIn('id', [1, 2, 3, 4])->get();
        } elseif ($user  == 3 or $user == 4) {
            $menu = menu::whereIn('id', [2])->get();
        } else {
            $menu = new menu();
        }
        $notifications = SuperAdminNotification::all();
        // dd(session('user')->role);
        if (session('user')->role == 1) {
            $k = DB::select('SELECT *, schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id ORDER BY schedule.id DESC');
        } elseif (session('user')->role == 3) {
            $k = DB::select("SELECT *, schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id
            where doctor.lab_partners ='Pythokind' ORDER BY schedule.id DESC");
        } elseif (session('user')->role == 4) {
            $k = DB::select("SELECT *, schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id
             and doctor.lab_partners ='thyrocare' ORDER BY schedule.id DESC");
        } elseif (session('user')->role == 5) {
            $qy = "
                SELECT
                schedule.id as s_id,
                schedule.doctor_id,
                schedule.status,
                schedule.agent,
                schedule.agent_contact,
                schedule.agent_schedule_datetime,
                schedule.result,
                schedule.upload_report,
                schedule.user_id,
                schedule.accept_reject,
                schedule.created_at,
                schedule.updated_at,
                doctor.id,
                doctor.name,
                doctor.specialties,
                doctor.contact,
                doctor.email,
                doctor.session_user_id,
                doctor.agree_disagree,
                doctor.sample_collection_date,
                doctor.sample_collection_time,
                doctor.address_line,
                doctor.state,
                doctor.city,
                doctor.pincode,
                doctor.lab_partners,
                doctor.test_cycle,
                doctor.created_at,
                doctor.updated_at,
                doctor.esign,
                credentials.role,
                manager.name as m_name,
                credentials.manager,
                manager.email as m_email
            FROM schedule
            JOIN doctor ON schedule.doctor_id = doctor.id
            JOIN credentials ON credentials.id = schedule.user_id
            LEFT JOIN manager ON manager.id = credentials.manager
            WHERE manager = '" . session('user')->email . "'
            ";
            $k = DB::select($qy);
        } else {
            $k = DB::select('SELECT *, schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id WHERE schedule.user_id = ' . session('user')->id . ' ORDER BY schedule.id DESC');
        }
        return view(
            'WebsitePages.SuperAdmin.schedule',
            [
                "title" => (!empty($title->title)) ? $title->title : 'schedule',
                "compony_details" => $compony_details,
                "menu" => $menu->all(),
                "sub_menu" => $menu2->getMenuWithSubmenus(),
                'notifications' => $notifications,
                'schedule' => $k,
            ]
        );
    }
    public function add_person($id)
    {
        $title = SystemPage::where('name', 'add_person')->first();
        $doctor_data = SuperAdminSchedule::where('id', $id)->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        $assign_fibo = DB::select("SELECT 
        schedule.id AS schedule_id,
        schedule.doctor_id AS schedule_doctor_id,
        schedule.status AS schedule_status,
        schedule.agent AS schedule_agent,
        schedule.agent_contact AS schedule_agent_contact,
        schedule.agent_schedule_datetime AS schedule_agent_schedule_datetime,
        schedule.result AS schedule_result,
        schedule.upload_report AS schedule_upload_report,
        schedule.user_id AS schedule_user_id,
        schedule.created_at AS schedule_created_at,
        schedule.updated_at AS schedule_updated_at,
        doctor.id AS doctor_id,
        doctor.name AS doctor_name,
        doctor.specialties AS doctor_specialties,
        doctor.contact AS doctor_contact,
        doctor.email AS doctor_email,
        doctor.align AS doctor_align,
        doctor.session_user_id AS doctor_session_user_id,
        doctor.agree_disagree AS doctor_agree_disagree,
        doctor.sample_collection_date AS doctor_sample_collection_date,
        doctor.sample_collection_time AS doctor_sample_collection_time,
        doctor.address_line AS doctor_address_line,
        doctor.state AS doctor_state,
        doctor.city AS doctor_city,
        doctor.pincode AS doctor_pincode,
        doctor.lab_partners AS doctor_lab_partners,
        doctor.test_cycle AS doctor_test_cycle,
        doctor.esign AS doctor_esign
    FROM 
        schedule
    INNER JOIN 
        doctor ON schedule.doctor_id = doctor.id
    WHERE 
        schedule.id = :id", ['id' => $id]);
        return view(
            'WebsitePages.SuperAdmin.add_person',
            [
                "title" => (!empty($title->title)) ? $title->title : 'add_person',
                "compony_details" => $compony_details,
                'doctor_data' => $doctor_data,
                'assign_fibo' => $assign_fibo[0],
            ]
        );
    }
    public function add_person_post(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "add_person" => ["required"],
            "agent_contact" => ["required"],
            "agent_schedule_datetime" => ["required"],
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            DB::beginTransaction();
            $data = SuperAdminSchedule::where('id', $request['schedule_id'])->first();
            SuperAdminSchedule::where('id', $request['schedule_id'])->update([
                'agent' => $request['add_person'],
                'agent_contact' => $request['agent_contact'],
                'agent_schedule_datetime' => $request['agent_schedule_datetime'],
                'status' => 'agent align',
            ]);
            track::create([
                'status' => 'agent align',
                'doctor_id' => $data->doctor_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();
            return redirect()->route('schedule');
        } catch (\Exception $e) {
            DB::rollBack();
            FacadesLog::error('Error updating add_person_post: ' . $e->getMessage());
            return back()->withErrors(['issue' => 'add_person_post failed '])->withInput();
        }
    }
    public function upload_report($id)
    {
        $title = SystemPage::where('name', 'upload_report')->first();
        $doctor_data = SuperAdminSchedule::where('id', $id)->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        return view(
            'WebsitePages.SuperAdmin.upload_report',
            [
                "title" => (!empty($title->title)) ? $title->title : 'upload_report',
                "compony_details" => $compony_details,
                'doctor_data' => $doctor_data,
            ]
        );
    }
    public function upload_report_post(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "schedule_id" => ["required"],
            "result" => ["required"],
            "report" => ["required"],
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            $file = $request->file('report');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            // $file->storeAs('public/reports', $fileName);
            // $base64File = base64_encode(file_get_contents($file->path()));
            // dd($base64File);
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $publicPath = public_path('reports');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            $file->move($publicPath, $fileName);
            DB::beginTransaction();
            $data = SuperAdminSchedule::where('id', $request['schedule_id'])->first();
            SuperAdminSchedule::where('id', $request['schedule_id'])->update([
                'result' => $request['result'],
                'upload_report' => $fileName,
                'status' => 'report upload',
            ]);
            track::create([
                'status' => 'report upload',
                'doctor_id' => $data->doctor_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();
            return redirect()->route('schedule');
        } catch (\Exception $e) {
            DB::rollBack();
            FacadesLog::error('Error updating upload_report_post: ' . $e->getMessage());
            return back()->withErrors(['issue' => 'upload_report_post failed '])->withInput();
        }
    }
    public function schedule_id_delete_post($id)
    {
        try {
            DB::beginTransaction();
            $k = SuperAdminSchedule::where('id', $id)->first();
            if (!empty($k->upload_report)) {
                $filePath = public_path('reports\\' . $k->upload_report);
                if (file_exists($filePath)) {
                    try {
                        unlink($filePath);
                    } catch (\Exception $e) {
                        error_log('Error deleting file: ' . $e->getMessage());
                    }
                }
            }
            SuperAdminSchedule::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('schedule');
        } catch (\Exception $e) {
            DB::rollBack();
            FacadesLog::error('Error delete schedule_id_delete_post: ' . $e->getMessage());
            return back()->withErrors(['issue' => 'schedule_id_delete_post failed '])->withInput();
        }
    }
    public function schedule_id_edit($id)
    {
        $title = SystemPage::where('name', 'schedule_id_edit')->first();
        $doctor_data = SuperAdminSchedule::where('id', $id)->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        return view(
            'WebsitePages.SuperAdmin.schedule_id_edit',
            [
                "title" => (!empty($title->title)) ? $title->title : 'schedule_id_edit',
                "compony_details" => $compony_details,
                'doctor_data' => $doctor_data,
            ]
        );
    }
    public function schedule_id_edit_post(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "schedule_id" => ["required"],
            "agent" => ["required"],
            "result" => ["required"],
            "agent_contact" => ["required"],
            "agent_schedule_datetime" => ["required"],
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            $data = SuperAdminSchedule::where('id', $request['schedule_id'])->first();
            if (isset($request['report'])) {
                $file = $request->file('report');
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $publicPath = public_path('reports');
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                $file->move($publicPath, $fileName);
                if (!empty($data->upload_report)) {
                    $filePath = public_path('reports\\' . $data->upload_report);
                    if (file_exists($filePath)) {
                        try {
                            unlink($filePath);
                        } catch (\Exception $e) {
                            error_log('Error deleting file: ' . $e->getMessage());
                        }
                    }
                }
            } else {
                $fileName = $data->upload_report;
            }
            DB::beginTransaction();
            SuperAdminSchedule::where('id', $request['schedule_id'])->update([
                'agent' => $request['agent'],
                'result' => $request['result'],
                'agent_contact' => $request['agent_contact'],
                'upload_report' => $fileName,
                'status' => 'report upload',
            ]);
            DB::commit();
            return redirect()->route('schedule');
        } catch (\Exception $e) {
            DB::rollBack();
            FacadesLog::error('Error updating schedule_id_edit_post: ' . $e->getMessage());
            return back()->withErrors(['issue' => 'schedule_id_edit_post failed '])->withInput();
        }
    }
    public function medicine_reminder()
    {
        $title = SystemPage::where('name', 'medicine_reminder')->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        $menu2 = new menu();
        $user =  session('user')->role;
        if ($user  == 2) {
            $menu = menu::whereIn('id', [1, 2, 3, 4])->get();
        } elseif ($user  == 3 or $user == 4) {
            $menu = menu::whereIn('id', [2])->get();
        } else {
            $menu = new menu();
        }
        $notifications = SuperAdminNotification::all();
        if (session('user')->role == 1) {
            $k = DB::select("SELECT *,schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id where schedule.result < 25 AND schedule.result IS NOT NULL AND schedule.result != ''");
        } elseif (session('user')->role == 5) {
            $qy = "
                SELECT
                schedule.id as s_id,
                schedule.doctor_id,
                schedule.status,
                schedule.agent,
                schedule.agent_contact,
                schedule.agent_schedule_datetime,
                schedule.result,
                schedule.upload_report,
                schedule.user_id,
                schedule.accept_reject,
                schedule.created_at,
                schedule.updated_at,
                doctor.id,
                doctor.name,
                doctor.specialties,
                doctor.contact,
                doctor.email,
                doctor.session_user_id,
                doctor.agree_disagree,
                doctor.sample_collection_date,
                doctor.sample_collection_time,
                doctor.address_line,
                doctor.state,
                doctor.city,
                doctor.pincode,
                doctor.lab_partners,
                doctor.test_cycle,
                doctor.created_at,
                doctor.updated_at,
                doctor.esign,
                credentials.role,
                manager.name as m_name,
                credentials.manager,
                manager.email as m_email
            FROM schedule
            JOIN doctor ON schedule.doctor_id = doctor.id
            JOIN credentials ON credentials.id = schedule.user_id
            LEFT JOIN manager ON manager.id = credentials.manager
            WHERE manager = '" . session('user')->email . "'
            AND schedule.result < 25 
            AND schedule.result IS NOT NULL 
            AND schedule.result != ''
            ";
            $k = DB::select($qy);
        } else {
            $k = DB::select("SELECT *,schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id where  schedule.user_id =" . session('user')->id . " and schedule.result < 25 AND schedule.result  IS NOT NULL AND schedule.result != '' ");
        }
        return view(
            'WebsitePages.SuperAdmin.medicine_reminder',
            [
                "title" => (!empty($title->title)) ? $title->title : 'medicine_reminder',
                "compony_details" => $compony_details,
                "menu" => $menu->all(),
                "sub_menu" => $menu2->getMenuWithSubmenus(),
                'notifications' => $notifications,
                'schedule' => $k,
            ]
        );
    }
    public function medicine_reminder_get($id)
    {

        $title = SystemPage::where('name', 'schedule')->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        $menu2 = new menu();
        $user =  session('user')->role;
        if ($user  == 2) {
            $menu = menu::whereIn('id', [1, 2, 3, 4])->get();
        } elseif ($user  == 3 or $user == 4) {
            $menu = menu::whereIn('id', [2])->get();
        } else {
            $menu = new menu();
        }
        $notifications = SuperAdminNotification::all();
        $k1 = DB::select("SELECT *,schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id where schedule.result < 25  and schedule.id =$id ");
        $k = DB::select("SELECT *,schedule.id as s_id FROM schedule JOIN doctor ON schedule.doctor_id = doctor.id where schedule.result < 25 AND schedule.result IS NOT NULL AND schedule.result != ''");
        try {
            $response = Http::get('https://thewhatsappmarketing.com/api/send', [
                'number' => $k1[0]->contact,
                'type' => 'text',
                'message' => 'Dear Doctor, Please take your today\'s medicine',
                'instance_id' => '65B654523DFFD',
                'access_token' => '65742a6cedff6',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $m = "WhatsApp message sent successfully!";
            }
        } catch (\Throwable $e) {
            $m = "Failed to send WhatsApp message. Error: ";
        }
        Session::flash('notification', $m);
        return redirect()->route('medicine_reminder');
        // return view(
        //     'WebsitePages.SuperAdmin.medicine_reminder',
        //     [
        //         "title" => (!empty($title->title)) ? $title->title : 'medicine_reminder',
        //         "compony_details" => $compony_details,
        //         "menu" => $menu->all(),
        //         "sub_menu" => $menu2->getMenuWithSubmenus(),
        //         'notifications' => $notifications,
        //         'schedule' => $k,
        //     ]
        // );
    }
    public function track()
    {
        $title = SystemPage::where('name', 'track')->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        $menu2 = new menu();
        $user =  session('user')->role;
        if ($user  == 2) {
            $menu = menu::whereIn('id', [1, 2, 3, 4])->get();
        } elseif ($user  == 3 or $user == 4) {
            $menu = menu::whereIn('id', [2])->get();
        } else {
            $menu = new menu();
        }
        $notifications = SuperAdminNotification::all();
        if (session('user')->role == 1) {
            $k = DB::select("SELECT track.*, doctor.*, schedule.*,track.id as track_data_id,doctor.name as doctor_name 
            FROM track
            JOIN doctor ON track.doctor_id = doctor.id
            JOIN schedule ON track.doctor_id = schedule.doctor_id
            WHERE (track.doctor_id, track.id) IN (
                SELECT doctor_id, MAX(id) AS max_id
                FROM track
                GROUP BY doctor_id
            );");
        } elseif (session('user')->role == 5) {
            $qy = "
            SELECT 
            track.id as track_data_id,
            track.doctor_id as doctor_id,
            track.status as status,
            doctor.name as doctor_name,
            credentials.*,
            manager.*
        FROM 
            track
        JOIN 
            doctor ON track.doctor_id = doctor.id
        JOIN 
            schedule ON track.doctor_id = schedule.doctor_id
        JOIN 
            credentials ON credentials.id = schedule.user_id
        LEFT JOIN 
            manager ON manager.id = credentials.manager
        WHERE 
        (track.doctor_id, track.id) IN (
                SELECT 
                    doctor_id, 
                    MAX(id) AS max_id
                FROM 
                    track
                GROUP BY 
                    doctor_id
            )
            AND manager = '" . session('user')->email . "';
            ";
            $k = DB::select($qy);
        } else {
            $k = DB::select("SELECT track.*, doctor.*, schedule.user_id ,track.id as track_data_id,doctor.name as doctor_name FROM track JOIN doctor ON track.doctor_id = doctor.id JOIN schedule ON track.doctor_id = schedule.doctor_id WHERE (track.doctor_id, track.id) IN ( SELECT doctor_id, MAX(id) AS max_id FROM track GROUP BY doctor_id ) AND schedule.user_id = " . session('user')->id);
        }
        return view(
            'WebsitePages.SuperAdmin.track',
            [
                "title" => (!empty($title->title)) ? $title->title : 'track',
                "compony_details" => $compony_details,
                "menu" => $menu->all(),
                "sub_menu" => $menu2->getMenuWithSubmenus(),
                'notifications' => $notifications,
                'schedule' => $k,
            ]
        );
    }
    public function track_id($id)
    {
        $title = SystemPage::where('name', 'track')->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        $menu2 = new menu();
        $user =  session('user')->role;
        if ($user  == 2) {
            $menu = menu::whereIn('id', [1, 2, 3, 4])->get();
        } elseif ($user  == 3 or $user == 4) {
            $menu = menu::whereIn('id', [2])->get();
        } else {
            $menu = new menu();
        }
        $notifications = SuperAdminNotification::all();
        $count = track::where('doctor_id', $id)->count();
        // if (session('user')->role == 1) {
        //     $k = DB::select("SELECT t.id, t.doctor_id, t.status, t.created_at, t.updated_at, d.name, s.user_id FROM track AS t JOIN doctor AS d ON t.doctor_id = d.id JOIN schedule AS s ON t.doctor_id = s.doctor_id WHERE
        //     t.doctor_id = $id;");
        // } else {
        //     $k = DB::select("SELECT
        //     t.id,
        //     t.doctor_id,
        //     t.status,
        //     t.created_at,
        //     t.updated_at,
        //     d.name,
        //     s.user_id
        // FROM
        //     track AS t
        // JOIN
        //     doctor AS d ON t.doctor_id = d.id
        // JOIN
        //     schedule AS s ON t.doctor_id = s.doctor_id
        // WHERE
        //     t.doctor_id = $id
        //     AND s.user_id =".session('user')->id.";");
        // }
        if (session('user')->role == 1) {
            $qy = "
                SELECT 
                    '' as id,
                    '2' as doctor_id,
                    'Dr Choose' as status,
                    '' as created_at,
                    '' as updated_at,
                    '' as name,
                    '' as user_id,
                    'fa-stethoscope' as icon

                UNION ALL

                SELECT 
                    t.id,
                    t.doctor_id,
                    t.status,
                    t.created_at,
                    t.updated_at,
                    d.name,
                    s.user_id,
                    CASE 
                        WHEN t.status = 'Dr Choose' THEN 'fa-stethoscope'
                        WHEN t.status = 'schedule' THEN 'fa-tachometer'
                        WHEN t.status = 'agent align' THEN 'fa-child'
                        WHEN t.status = 'report upload' THEN 'fa-fax'
                        ELSE NULL
                    END AS icon
                FROM 
                    track AS t
                JOIN 
                    doctor AS d ON t.doctor_id = d.id
                JOIN 
                    schedule AS s ON t.doctor_id = s.doctor_id
                WHERE 
                t.doctor_id = " . $id . "

                UNION ALL

                SELECT 
                    '' as id,
                    '' as doctor_id,
                    'agent align' as status,
                    '' as created_at,
                    '' as updated_at,
                    '' as name,
                    '' as user_id,
                    'fa-child' as icon

                UNION ALL

                SELECT 
                    '' as id,
                    '' as doctor_id,
                    'report upload' as status,
                    '' as created_at,
                    '' as updated_at,
                    '' as name,
                    '' as user_id,
                    'fa-fax' as icon;

            ";
            $k = DB::select($qy);
        } else {
            $qy = "
                SELECT 
                    '' as id,
                    '2' as doctor_id,
                    'Dr Choose' as status,
                    '' as created_at,
                    '' as updated_at,
                    '' as name,
                    '' as user_id,
                    'fa-stethoscope' as icon

                UNION ALL

                SELECT 
                    t.id,
                    t.doctor_id,
                    t.status,
                    t.created_at,
                    t.updated_at,
                    d.name,
                    s.user_id,
                    CASE 
                        WHEN t.status = 'Dr Choose' THEN 'fa-stethoscope'
                        WHEN t.status = 'schedule' THEN 'fa-tachometer'
                        WHEN t.status = 'agent align' THEN 'fa-child'
                        WHEN t.status = 'report upload' THEN 'fa-fax'
                        ELSE NULL
                    END AS icon
                FROM 
                    track AS t
                JOIN 
                    doctor AS d ON t.doctor_id = d.id
                JOIN 
                    schedule AS s ON t.doctor_id = s.doctor_id
                WHERE 
                    t.doctor_id = " . $id . "
                    AND s.user_id =" . session('user')->id . "

                UNION ALL

                SELECT 
                    '' as id,
                    '' as doctor_id,
                    'agent align' as status,
                    '' as created_at,
                    '' as updated_at,
                    '' as name,
                    '' as user_id,
                    'fa-child' as icon

                UNION ALL

                SELECT 
                    '' as id,
                    '' as doctor_id,
                    'report upload' as status,
                    '' as created_at,
                    '' as updated_at,
                    '' as name,
                    '' as user_id,
                    'fa-fax' as icon;

            ";
            $k = DB::select($qy);
        }
        return view(
            'WebsitePages.SuperAdmin.track_id',
            [
                "title" => (!empty($title->title)) ? $title->title : 'track',
                "compony_details" => $compony_details,
                "menu" => $menu->all(),
                "sub_menu" => $menu2->getMenuWithSubmenus(),
                'notifications' => $notifications,
                'schedule' => $k,
                'count' => $count,
                'd_id' => $id,
            ]
        );
    }
    public function add_person_regect($id)
    {
        $title = SystemPage::where('name', 'add_person')->first();
        $doctor_data = SuperAdminSchedule::where('id', $id)->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        $assign_fibo = DB::select("SELECT 
        schedule.id AS schedule_id,
        schedule.doctor_id AS schedule_doctor_id,
        schedule.status AS schedule_status,
        schedule.agent AS schedule_agent,
        schedule.agent_contact AS schedule_agent_contact,
        schedule.agent_schedule_datetime AS schedule_agent_schedule_datetime,
        schedule.accept_reject AS schedule_accept_reject,
        schedule.result AS schedule_result,
        schedule.upload_report AS schedule_upload_report,
        schedule.user_id AS schedule_user_id,
        schedule.created_at AS schedule_created_at,
        schedule.updated_at AS schedule_updated_at,
        doctor.id AS doctor_id,
        doctor.name AS doctor_name,
        doctor.specialties AS doctor_specialties,
        doctor.contact AS doctor_contact,
        doctor.email AS doctor_email,
        doctor.align AS doctor_align,
        doctor.session_user_id AS doctor_session_user_id,
        doctor.agree_disagree AS doctor_agree_disagree,
        doctor.sample_collection_date AS doctor_sample_collection_date,
        doctor.sample_collection_time AS doctor_sample_collection_time,
        doctor.address_line AS doctor_address_line,
        doctor.state AS doctor_state,
        doctor.city AS doctor_city,
        doctor.pincode AS doctor_pincode,
        doctor.lab_partners AS doctor_lab_partners,
        doctor.test_cycle AS doctor_test_cycle,
        doctor.esign AS doctor_esign
    FROM 
        schedule
    INNER JOIN 
        doctor ON schedule.doctor_id = doctor.id
    WHERE 
        schedule.id = :id", ['id' => $id]);
        return view(
            'WebsitePages.SuperAdmin.add_person_regect',
            [
                "title" => (!empty($title->title)) ? $title->title : 'add_person_regect',
                "compony_details" => $compony_details,
                'doctor_data' => $doctor_data,
                'assign_fibo' => $assign_fibo[0],
            ]
        );
    }
    public function add_person_regect_post(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "schedule_accept_reject" => ["required"],
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            DB::beginTransaction();
            SuperAdminSchedule::where('id', $request['schedule_id'])->update([
                'accept_reject' => $request['schedule_accept_reject'],
            ]);
            DB::commit();
            return redirect()->route('schedule');
        } catch (\Exception $e) {
            DB::rollBack();
            FacadesLog::error('Error updating add_person_regect_post: ' . $e->getMessage());
            return back()->withErrors(['issue' => 'add_person_regect_post failed '])->withInput();
        }
    }
}
