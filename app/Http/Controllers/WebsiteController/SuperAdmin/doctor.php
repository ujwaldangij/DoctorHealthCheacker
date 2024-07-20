<?php

namespace App\Http\Controllers\WebsiteController\SuperAdmin;

use Log;
use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\WebsiteModels\SuperAdmin\menu;
use App\Models\WebsiteModels\SuperAdmin\Credential;
use App\Models\WebsiteModels\SuperAdmin\SystemPage;
use App\Models\WebsiteModels\SuperAdmin\ComponyDetail;
use App\Models\WebsiteModels\SuperAdmin\doctor as SuperAdminDoctor;
use App\Models\WebsiteModels\SuperAdmin\Notification as SuperAdminNotification;
use App\Models\WebsiteModels\SuperAdmin\schedule;
use App\Models\WebsiteModels\SuperAdmin\track;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Validator;


class doctor extends Controller
{
    public function index()
    {
        $title = SystemPage::where('name', 'doctor')->first();
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
        } elseif ($user == 5) {
            $menu = menu::whereIn('id', [2, 3, 4])->get();
        } else {
            $menu = new menu();
        }
        $notifications = SuperAdminNotification::all();
        if (session('user')->role == 5) {
            $dataPut = DB::select('
                    SELECT doctor.*, schedule.lab_partners, schedule.test_cycle
                    FROM doctor
                    JOIN (
                        SELECT doctor_id, lab_partners, test_cycle
                        FROM schedule
                        WHERE (doctor_id, test_cycle) IN (
                            SELECT doctor_id, MAX(test_cycle) AS max_test_cycle
                            FROM schedule
                            GROUP BY doctor_id
                        )
                    ) AS schedule ON doctor.id = schedule.doctor_id
                    WHERE doctor.user_mr = ?
                    ORDER BY doctor.id DESC;
                ', [session('user')->manager]);
        }elseif (session('user')->role == 2) {
            $dataPut = DB::select('
                SELECT doctor.*, schedule.lab_partners, schedule.test_cycle
                FROM doctor
                LEFT JOIN (
                    SELECT doctor_id, lab_partners, test_cycle
                    FROM schedule
                    WHERE (doctor_id, test_cycle) IN (
                        SELECT doctor_id, MAX(test_cycle) AS max_test_cycle
                        FROM schedule
                        GROUP BY doctor_id
                    )
                ) AS schedule ON doctor.id = schedule.doctor_id
                WHERE doctor.session_user_id = ?
                ORDER BY doctor.id DESC;
            ', [session('user')->id]);
        }  
        else {
            $dataPut = DB::select('
                SELECT doctor.*, schedule.lab_partners, schedule.test_cycle
                FROM doctor
                LEFT JOIN (
                    SELECT doctor_id, lab_partners, test_cycle
                    FROM schedule
                    WHERE (doctor_id, test_cycle) IN (
                        SELECT doctor_id, MAX(test_cycle) AS max_test_cycle
                        FROM schedule
                        GROUP BY doctor_id
                    )
                ) AS schedule ON doctor.id = schedule.doctor_id
                ORDER BY doctor.id DESC;
            ');
        }
        // dd($dataPut[0]->test_cycle);
        return view(
            'WebsitePages.SuperAdmin.doctor',
            [
                "title" => (!empty($title->title)) ? $title->title : 'doctor',
                "compony_details" => $compony_details,
                "menu" => $menu->all(),
                "sub_menu" => $menu2->getMenuWithSubmenus(),
                'notifications' => $notifications,
                'doctor' => $dataPut,
            ]
        );
    }
    public function choose($id)
    {
        $title = SystemPage::where('name', 'login')->first();
        $doctor_data = SuperAdminDoctor::where('id', $id)->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        return view(
            'WebsitePages.SuperAdmin.choose',
            [
                "title" => (!empty($title->title)) ? $title->title : 'Choose Doctor Id',
                "compony_details" => $compony_details,
                'doctor_data' => $doctor_data,
            ]
        );
    }
    public function postchooseid(Request $request)
    {
        if ($request->input('agree_disagree') === 'agree') {
            // Add additional validation rules for fields required when agree_disagree is 'agree'
            $rules['agree_disagree'] = ["required"];
            $rules['doctor_id'] = ["required"];
            $rules['Doctor_name'] = ["required"];
            $rules['Doctor_contact'] = ["required"];
            $rules['Doctor_email'] = ["required", "email"];
            $rules['sample_collection_date'] = ["required"];
            $rules['sample_collection_time'] = ["required"];
            $rules['address_line'] = ["required"];
            $rules['state'] = ["required"];
            $rules['city'] = ["required"];
            $rules['pincode'] = ["required"];
            $rules['lab_partners'] = ["required"];
            $rules['test_cycle'] = ["required"];
            $rules['esign'] = ["required"];

            $validate = Validator::make($request->all(), $rules);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }
            try {
                if ($request['test_cycle'] == 2) {
                    try {
                        DB::delete("DELETE FROM track WHERE doctor_id = ?", [$request['doctor_id']]);
                    } catch (\Throwable $e) {
                    }
                }
                DB::beginTransaction();
                // Your update logic here
                // dd(session('user')->manager);
                SuperAdminDoctor::where('id', $request->doctor_id)->update([
                    'name' => $request->Doctor_name,
                    'specialties' => $request->specialties,
                    'contact' => $request->Doctor_contact,
                    'email' => $request->Doctor_email,
                    'align' => 'yes',
                    'session_user_id' => session('user')->id,
                    'agree_disagree' => $request->agree_disagree,
                    'sample_collection_date' => $request->sample_collection_date,
                    'sample_collection_time' => $request->sample_collection_time,
                    'address_line' => $request->address_line,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                    'esign' => $request->esign,
                    'user_mr' => session('user')->manager
                ]);
                track::create([
                    'status' => 'scheduled',
                    'doctor_id' => $request['doctor_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                schedule::create([
                    'doctor_id' => $request['doctor_id'],
                    'status' => 'scheduled',
                    'agent' => '',
                    'result' => '',
                    'upload_report' => '',
                    'user_id' => session('user')->id,
                    'lab_partners' => $request->lab_partners,
                    'test_cycle' => $request->test_cycle,
                ]);
                // Commit the transaction if everything is successful
                DB::commit();

                // Success response or redirection
                return redirect()->route('choose_doctor');
            } catch (\Exception $e) {
                DB::rollBack();
                FacadesLog::error('Error updating postchooseid: ' . $e->getMessage());
                return back()->withErrors(['issue' => 'Update failed postchooseid'])->withInput();
            }
        } else {
            $validate = Validator::make($request->all(), [
                "agree_disagree" => ["required"],
                // "Doctor_name" => ["required"],
                // "Doctor_contact" => ["required"],
                // "Doctor_email" => ["required"],
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }
            try {
                // Use a transaction to ensure data consistency
                DB::beginTransaction();
                // Your update logic here
                SuperAdminDoctor::where('id', $request['doctor_id'])->update([
                    'name' => $request->Doctor_name,
                    'specialties' => $request->specialties,
                    'contact' => $request->Doctor_contact,
                    'email' => $request->Doctor_email,
                    'align' => 'no',
                    'session_user_id' => session('user')->id,
                    'agree_disagree' => $request->agree_disagree,
                    'user_mr' => session('user')->manager
                ]);
                DB::commit();
                // Success response or redirection
                return redirect()->route('choose_doctor');
            } catch (\Exception $e) {
                DB::rollBack();
                FacadesLog::error('Error updating postchooseid: ' . $e->getMessage());
                return back()->withErrors(['issue' => 'Update failed postchooseid'])->withInput();
            }
        }
    }
    public function choose_id_delete($id)
    {
        // dd('yes');
        try {
            // Use a transaction to ensure data consistency
            DB::beginTransaction();
            SuperAdminDoctor::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('choose_doctor');
        } catch (\Exception $e) {
            DB::rollBack();
            FacadesLog::error('Error delete choose_id_delete: ' . $e->getMessage());
            return back()->withErrors(['issue' => 'choose_id_delete failed '])->withInput();
        }
    }
    public function choose_id_edit($id)
    {
        $title = SystemPage::where('name', 'login')->first();
        $doctor_data = SuperAdminDoctor::where('id', $id)->first();
        $compony_details = ComponyDetail::where('id', '1')->first();
        if (empty($compony_details)) {
            $compony_details['name'] = 'demo';
            $compony_details['developed'] = 'demo';
        }
        return view(
            'WebsitePages.SuperAdmin.editchoose',
            [
                "title" => (!empty($title->title)) ? $title->title : 'Choose Doctor Id',
                "compony_details" => $compony_details,
                'doctor_data' => $doctor_data,
            ]
        );
    }
    public function choose_id_edit_post(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "Doctor_name" => ["required"],
            "Doctor_contact" => ["required"],
            "Doctor_email" => ["required"],
            "specialties" => ["required"],
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            // Use a transaction to ensure data consistency
            DB::beginTransaction();

            // Your update logic here
            SuperAdminDoctor::where('id', $request['doctor_id'])->update([
                'align' => 'no',
                'esign' => '',
                'name' => $request['Doctor_name'],
                'contact' => $request['Doctor_contact'],
                'email' => $request['Doctor_email'],
                'specialties' => $request['specialties'],
            ]);
            DB::commit();

            // Success response or redirection
            return redirect()->route('choose_doctor');
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollBack();
            // Log the exception for debugging purposes
            FacadesLog::error('Error updating choose_id_edit_post: ' . $e->getMessage());
            return back()->withErrors(['issue' => 'choose_id_edit_post failed '])->withInput();
        }
    }
}
