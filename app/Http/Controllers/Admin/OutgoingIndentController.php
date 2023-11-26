<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Indent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OutgoingIndentController extends Controller
{
    public function outgoing()
    {
        return view('backend.indent.outgoing');
    }
    public function all_data(Request $request)
    {

        if ($request->ajax()) {

            $insp_id = Auth::user()->inspectorate_id;
            $admin_id = Auth::user()->id;
            $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
            $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
            $desig_position = Designation::where('id', $designation_id)->first();


            if (Auth::user()->id == 92) {
                $query = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('indents.status', '=', 1)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $indentId = [];
                if ($query) {
                    foreach ($query as $indent) {
                        array_push($indentId, $indent->id);
                    }
                }
                $document_tracks_sender_id = DocumentTrack::whereIn('doc_ref_id', $indentId)
                    ->where('sender_designation_id', $designation_id)
                    ->first();

                //......End for DataTable Forward and Details btn change
            } elseif ($desig_position->id == 1) {

                $query = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('indents.status', '=', 1)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $indentId = [];
                if ($query) {
                    foreach ($query as $indent) {
                        array_push($indentId, $indent->id);
                    }
                }
                $document_tracks_sender_id = DocumentTrack::whereIn('doc_ref_id', $indentId)
                    ->where('sender_designation_id', $designation_id)
                    ->first();

                //......End for DataTable Forward and Details btn change
            } else {

                $query = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('indents.insp_id', $insp_id)
                    ->whereIn('indents.sec_id', $section_ids)
                    ->where('indents.status', '=', 1)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $indentId = [];
                if ($query) {
                    foreach ($query as $indent) {
                        array_push($indentId, $indent->id);
                    }
                }

                $document_tracks_sender_id = DocumentTrack::whereIn('doc_ref_id', $indentId)
                    ->where('sender_designation_id', $designation_id)
                    ->first();
                //......End for DataTable Forward and Details btn change


                //......Start for showing data for receiver designation

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $indentId)
                    ->where('reciever_desig_id', $designation_id)
                    ->first();



                if (!$document_tracks_receiver_id) {
                    $query = Indent::where('id', 'no data')->get();
                }
                  //......End for showing data for receiver designation
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
                        return '<button class="btn btn-success btn-sm">Delivered</button>';
                    }
                })
                ->addColumn('action', function ($data) use ($document_tracks_sender_id, $designation_id) {

                    if ($document_tracks_sender_id == null) {

                        $btnName = 'Vetted';
                    } else {

                        if ($document_tracks_sender_id->sender_designation_id == $designation_id) {
                            $btnName = 'Details';
                        } else {

                            $btnName = 'Vetted';
                        }
                    }

                    if ($data->status == '2') {
                        $actionBtn = '<div class="btn-group" role="group">
                        <a href="' . url('admin/outgoing_indent/progress/' . $data->id) . '" class="edit btn btn-secondary btn-sm">Progress</a>
                        <button href="" class="edit btn btn-success btn-sm" disable>Completed</button>';
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">
                        <a href="' . url('admin/outgoing_indent/progress/' . $data->id) . '" class="edit btn btn-info btn-sm">Progress</a>
                        <a href="' . url('admin/outgoing_indent/details/' . $data->id) . '" class="edit btn btn-secondary btn-sm">' . $btnName . '</a>
                        </div>';
                    }


                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function details($id)
    {

        $details = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
            ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name')
            ->where('indents.id', $id)
            ->where('indents.status', 1)
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

        // delay cause for sec IC start

        return view('backend.indent.outgoing_details', compact('details', 'designations', 'document_tracks', 'desig_id', 'desig_position'));
    }

    public function OutgoingIndentTracking(Request $request)
    {
        // dd($request->id);
        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 3; // 3 for doc type indent from doctype table column doc_serial
        $doc_ref_id = $request->doc_ref_id;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = $section_ids[0];
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

        $desig_position = Designation::where('id', $sender_designation_id)->first();
        // dd( $desig_position);
        $data = new DocumentTrack();
        $data->ins_id = $ins_id;
        $data->section_id = $section_id;
        $data->doc_type_id = $doc_type_id;
        $data->doc_ref_id = $doc_ref_id;
        $data->track_status = 2;

        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->created_at = Carbon::now();
        $data->updated_at = Carbon::now();
        $data->save();

        // ----delay_cause start here

        $prelimgen = Indent::find($doc_ref_id);
        $prelimgen->delay_cause = $request->delay_cause;
        $prelimgen->delivery_date = $request->delivery_date;
        $prelimgen->delivery_by = Auth::user()->id;
        $prelimgen->save();


        // ----delay_cause end here

        if ($desig_position->position == 7) {

            $data = Indent::find($doc_ref_id);

            if ($data) {

                $data->status = 2;
                $data->save();

                $value = new DocumentTrack();
                $value->ins_id = $ins_id;
                $value->section_id = $section_id;
                $value->doc_type_id = $doc_type_id;
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
    public function progress($id)
    {

        return view('backend.indent.progress');
    }
}
