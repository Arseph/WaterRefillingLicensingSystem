<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\FacilityInspection;
use Illuminate\Support\Facades\DB;
use App\Models\InitialApplications;
use App\Models\OperationalApplications;

class InspectorController extends Controller
{
    public function index()
    {
        $data = InitialApplications::with('Client')->get();

        $compactdata = compact('data');

        $opapps = OperationalApplications::with('Client')->get();
        // return view('inspector', ['initapps' => $initapps, 'opapps'=>$opapps]);
        // return view('inspector', ['initapps' => $initapps]);
        // $initapps = InitialApplications::all();
        // return $initapps->toJson();
        return $compactdata;
    }

    //Retrieve inital application to display in its own DataTable
    public function initapps()
    {
        // $data = InitialApplications::whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For review')) . '%'])->with('Client')->get();
        // $data = InitialApplications::with('Client')->get();
        // $initapplication = InitialApplications::whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For review')) . '%'])->with('Client')->get();
        // $userprofile = UserProfile::with('UserAccount');
        $data = DB::table('tbl_user_profile')
            ->join('tbl_users', 'tbl_user_profile.user_id', '=', 'tbl_users.user_id')
            ->join('tbl_initapplication', 'tbl_user_profile.user_id', '=', 'tbl_initapplication.user_id')
            ->join('tbl_facility', 'tbl_initapplication.fac_id', '=', 'tbl_facility.fac_id')
            ->select('tbl_user_profile.firstname', 'tbl_user_profile.mi', 'tbl_user_profile.lastname', 'tbl_user_profile.gender', 'tbl_users.*', 'tbl_initapplication.*', 'tbl_facility.*')
            ->whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For scheduling')) . '%'])
            ->orWhereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('Failed')) . '%'])
            ->orWhereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For reinspection')) . '%'])
            ->get();
        return compact('data');
    }

    //Update the application status or remarks of the initial application record
    public function setInitAppInspection(Request $request, $id)
    {

        $initFacility = InitialApplications::find($id);

        //To check whether the facility with the provided id exists
        if ($initFacility) {

            $incomingFields = $request->validate([
                'application_status' => 'required',
                'inspection_date' => 'required',
                'inspector_name' => 'required',
            ]);

            //Checks whether the application has a prior inspection record or not
            //If it doesn't, it creates an entirely new inspection record in the facinspect table
            if ($initFacility->inspection_id == null || $initFacility->inspection_id == '') {
                $inspectiondata = [
                    'fac_id' => $initFacility->fac_id,
                    'inspector_name' => $incomingFields['inspector_name'],
                    'inspection_date' => $incomingFields['inspection_date'],
                    'inspection_status' => 'Pending inspection',
                    'reinspection_status' => null,
                    'reinspection_date' => null,
                    'inspection_form' => null,
                    'inspection_type' => 'Initial Inspection',
                    'remarks' => $request['remarks'],
                ];

                //To save the data inside the database
                $facilityinspection = FacilityInspection::create($inspectiondata);

                $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);
                $request['remarks'] = strip_tags($request['remarks']);

                $initFacility->application_status = $incomingFields['application_status'];
                $initFacility->remarks = $request['remarks'];
                $initFacility->late_remarks = $request['late_remarks'];
                $initFacility->late_date = $request['late_date'];
                $initFacility->inspection_id = $facilityinspection->inspection_id != '' || $facilityinspection->inspection_id != null ? $facilityinspection->inspection_id : null;
                $initFacility->inspector_date_action = Carbon::now()->format('Y-m-d');

                $initFacility->save();

                return response()->json([
                    'status' => 200,
                    // 'message'=>$facilityinspection->inspection_id
                    'message' => 'Facility status updated successfully',
                ]);
            }
            //If it does have a prior inspection record, it will check whether it needs to categorize it as a
            // reinspection type or create an entirely new record in the facinspect table
            else {

                $incomingFields = $request->validate([
                    'application_status' => 'required',
                    'inspection_date' => 'required',
                    'inspector_name' => 'required',
                    'reinspection_date' => 'required'
                ]);

                $facilityinspection = FacilityInspection::find($initFacility->inspection_id);

                //This one updates the old inspection record and adds a reinspection date
                if ($facilityinspection->reinspection_date == null || $facilityinspection->reinspection_date == '') {

                    $inspectiondata = [
                        'inspection_id' => $initFacility->inspection_id,
                        'fac_id' => $initFacility->fac_id,
                        'inspector_name' => $incomingFields['inspector_name'],
                        'inspection_status' => 'Failed',
                        'reinspection_status' => 'Pending reinspection',
                        'reinspection_date' => $incomingFields['reinspection_date'],
                        'inspection_form' => null,
                        'inspection_type' => 'Reinspection',
                        'remarks' => $request['remarks'],
                    ];

                    //To save the data inside the database
                    $facilityinspection->update($inspectiondata);

                    $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);
                    $request['remarks'] = strip_tags($request['remarks']);

                    $initFacility->application_status = $incomingFields['application_status'];
                    $initFacility->remarks = $request['remarks'];
                    $initFacility->late_remarks = $request['late_remarks'];
                    $initFacility->late_date = $request['late_date'];
                    $initFacility->inspector_date_reaction = Carbon::now()->format('Y-m-d');

                    $initFacility->save();

                    return response()->json([
                        'status' => 200,
                        // // 'message'=>$incomingFields['reinspection_date']
                        'message' => 'Inspection date saved successfully',
                    ]);
                }
                //This one assigns a new inspection id to this application
                else {
                    $incomingFields = $request->validate([
                        'application_status' => 'required',
                        'inspection_date' => 'required',
                        'inspector_name' => 'required',
                    ]);

                    $inspectiondata = [
                        'fac_id' => $initFacility->fac_id,
                        'inspector_name' => $incomingFields['inspector_name'],
                        'inspection_date' => $incomingFields['inspection_date'],
                        'inspection_status' => 'Pending inspection',
                        'reinspection_status' => null,
                        'reinspection_date' => null,
                        'inspection_form' => null,
                        'inspection_type' => 'Initial Inspection',
                        'remarks' => $request['remarks'],
                    ];

                    //To save the data inside the database
                    $facilityinspection = FacilityInspection::create($inspectiondata);

                    $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);
                    $request['remarks'] = strip_tags($request['remarks']);

                    $initFacility->application_status = $incomingFields['application_status'];
                    $initFacility->remarks = $request['remarks'];
                    $initFacility->late_remarks = $request['late_remarks'];
                    $initFacility->late_date = $request['late_date'];
                    $initFacility->inspection_id = $facilityinspection->inspection_id != '' || $facilityinspection->inspection_id != null ? $facilityinspection->inspection_id : null;

                    $initFacility->save();

                    return response()->json([
                        'status' => 200,
                        // 'message'=>$facilityinspection->inspection_id
                        'message' => 'Inspection date saved successfully',
                    ]);
                }
            }

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Failed to update facility status. Facility ID currently does not exist in the list for review.',
            ]);
        }
    }

    public function setInitAppRejection(Request $request, $id)
    {

        $initFacility = InitialApplications::find($id);

        //To check whether the facility with the provided id exists
        if ($initFacility) {

            $incomingFields = $request->validate([
                'application_status' => 'required',
                'inspector_name' => 'required',
            ]);

            $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);
            $request['remarks'] = strip_tags($request['remarks']);

            $initFacility->application_status = $incomingFields['application_status'];
            $initFacility->remarks = $request['remarks'];
            $initFacility->late_remarks = $request['late_remarks'];
            $initFacility->late_date = $request['late_date'];
            $initFacility->inspector_date_rejected = Carbon::now()->format('Y-m-d');

            $initFacility->save();

            return response()->json([
                'status' => 200,
                // 'message'=>$facilityinspection->inspection_id
                'message' => 'Application has been rejected',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Failed to update facility status. Facility ID currently does not exist in the list for review.',
            ]);
        }
    }

    //Retrieve inital application to display in its own DataTable
    public function opapps()
    {
        // $data = OperationalApplications::whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For review')) . '%'])->with('Client')->get();
        // $data = OperationalApplications::with('Client')->get();
        // $opapplication = OperationalApplications::whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For review')) . '%'])->with('Client')->get();
        // $userprofile = UserProfile::with('UserAccount');
        $data = DB::table('tbl_user_profile')
            ->join('tbl_users', 'tbl_user_profile.user_id', '=', 'tbl_users.user_id')
            ->join('tbl_operatepplication', 'tbl_user_profile.user_id', '=', 'tbl_operatepplication.user_id')
            ->select('tbl_user_profile.firstname', 'tbl_user_profile.mi', 'tbl_user_profile.lastname', 'tbl_user_profile.gender', 'tbl_users.*', 'tbl_operatepplication.*')
            ->whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For review')) . '%'])
            ->get();
        return compact('data');
    }

    //Update the application status or remarks of the operational application record
    public function updateOppApp()
    {

    }

    public function applicationlist()
    {
        $initapps = InitialApplications::with('Client')->get();
        $opapps = OperationalApplications::with('Client')->get();
        return view('inspector', ['initapps' => $initapps]);
    }
}
