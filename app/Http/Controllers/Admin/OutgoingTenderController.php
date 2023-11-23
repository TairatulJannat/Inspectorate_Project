<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Tender;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OutgoingTenderController extends Controller
{
    //
    public function outgoing()
    {
        return view('backend.tender.outgoing');
    }

    public function all_data(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $insp_id = Auth::user()->inspectorate_id;
            $admin_id = Auth::user()->id;
            $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();




            if (Auth::user()->id == 92) {
                $query = Tender::leftJoin('item_types', 'tenders.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'tenders.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'tenders.sec_id', '=', 'sections.id')
                    ->select('tenders.*', 'item_types.name as item_type_name', 'tenders.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('tenders.status', '=', 1)
                    ->get();
            } else {

                $query = Tender::leftJoin('item_types', 'tenders.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'tenders.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'tenders.sec_id', '=', 'sections.id')
                    ->select('tenders.*', 'item_types.name as item_type_name', 'tenders.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('tenders.insp_id', $insp_id)
                    ->whereIn('tenders.sec_id', $section_ids)
                    ->where('tenders.status', '=', 1)
                    ->get();

                $designation_ids = AdminSection::where('admin_id', $admin_id)->select('desig_id')->first();

                $prelimGenId = [];
                if ($query) {
                    foreach ($query as $prelimGen) {
                        array_push($prelimGenId, $prelimGen->id);
                    }
                }

                $document_tracks_receiver_ids = DocumentTrack::whereIn('doc_ref_id', $prelimGenId)
                    ->where('reciever_desig_id', $designation_ids->desig_id)
                    ->where('track_status', 2)
                    ->first();

                if (!$document_tracks_receiver_ids) {
                    $query = Tender::where('id', 'no data')->get();
                }
            }

            // $query->orderBy('id', 'asc');

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()

                ->addColumn('status', function ($data) {
                    if ($data->status == '0') {
                        return '<button class="btn btn-primary btn-sm">New</button>';
                    }
                    if ($data->status == '1') {
                        return '<button class="btn btn-warning  btn-sm">Under Vetted</button>';
                    }
                    if ($data->status == '2') {
                        return '<button class="btn btn-green btn-sm">Delivered</button>';
                    }
                })
                ->addColumn('action', function ($data) {

                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/outgoingtender/details/' . $data->id) . '" class="edit btn btn-secondary btn-lg">Vetted</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function details($id)
    {


        $details = Tender::leftJoin('item_types', 'tenders.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'tenders.sender', '=', 'dte_managments.id')
            ->select('tenders.*', 'item_types.name as item_type_name', 'tenders.*', 'dte_managments.name as dte_managment_name')
            ->where('tenders.id', $id)
            ->where('tenders.status', 1)
            ->first();

        $designations = Designation::all();

        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations', 'document_tracks.sender_designation_id', '=', 'designations.id')
            ->where('track_status', 2)
            ->select('document_tracks.*', 'designations.name as designations_name')->get();

        $auth_designation_id = AdminSection::where('admin_id', $admin_id)->first();
        if ($auth_designation_id) {

            $desig_id = $auth_designation_id->desig_id;
        }

        // delay cause for sec IC start

        $admin_id = Auth::user()->id;
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $sender_designation_id)->first();

        // delay cause for sec IC end

        return view('backend.tender.outgoing_details', compact('details', 'designations', 'document_tracks', 'desig_id', 'desig_position'));
    }

    public function OutgoingTenderTracking(Request $request)
    {
        // dd($request->id);
        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 4;
        $doc_ref_id = $request->doc_ref_id;
        // $remarks = $req uest->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = $section_ids[0];
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

        $desig_position = Designation::where('id', $sender_designation_id)->first();
        // dd( $desig_position);
        $data = new DocumentTrack();
        $data->ins_id = $ins_id;
        $data->section_id = $section_id;
        $data->doc_type_id = 4;
        $data->doc_ref_id = $doc_ref_id;
        $data->track_status = 2;

        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->created_at = Carbon::now();
        $data->updated_at = Carbon::now();
        $data->save();

        // ----delay_cause start here

        $prelimgen = Tender::find($doc_ref_id);
        $prelimgen->delay_cause = $request->delay_cause;
        $prelimgen->delivery_date = $request->delivery_date;
        $prelimgen->delivery_by = Auth::user()->id;
        $prelimgen->save();


        // ----delay_cause end here

        if ($desig_position->position == 7) {

            $data = Tender::find($doc_ref_id);

            if ($data) {

                $data->status = 2;
                $data->save();

                $value = new DocumentTrack();
                $value->ins_id = $ins_id;
                $value->section_id = $section_id;
                $value->doc_type_id = 4;
                $value->doc_ref_id = $doc_ref_id;
                $value->track_status = 2;
                $value->reciever_desig_id = $reciever_desig_id;
                $value->sender_designation_id = $sender_designation_id;
                $value->created_at = Carbon::now();
                $value->updated_at = Carbon::now();
                $value->save();
            }
        }




        return response()->json(['success' => 'Done']);
    }
}