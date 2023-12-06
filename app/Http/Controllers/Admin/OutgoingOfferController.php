<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Indent;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OutgoingOfferController extends Controller
{
    //
    public function outgoing()
    {
        return view('backend.offer.offer_outgoing.outgoing');
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
                $query = Offer::leftJoin('item_types', 'offers.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'offers.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'offers.sec_id', '=', 'sections.id')
                    ->select('offers.*', 'item_types.name as item_type_name', 'offers.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('offers.status', '=', 1)
                    ->get();
            } else {
                $offerIds = Offer::leftJoin('document_tracks', 'offers.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('offers.insp_id', $insp_id)
                    ->where('offers.status', 1)
                    ->whereIn('offers.sec_id', $section_ids)->pluck('offers.id', 'offers.id')->toArray();

                $query = Offer::leftJoin('item_types', 'offers.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'offers.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'offers.sec_id', '=', 'sections.id')
                    ->select('offers.*', 'item_types.name as item_type_name', 'offers.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('offers.id', $offerIds)
                    ->where('indenoffersts.status', '=', 1)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $offerId = [];
                if ($query) {
                    foreach ($query as $offer) {
                        array_push($offerId, $offer->id);
                    }
                }

                //......Start for showing data for receiver designation

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $offerId)
                    ->where('reciever_desig_id', $designation_id)
                    ->where('track_status', 2)
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = Offer::where('id', 'no data')->get();
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
                        return '<button class="btn btn-warning  btn-sm">Vetting On Process</button>';
                    }
                    if ($data->status == '2') {
                        return '<button class="btn btn-success btn-sm">Delivered</button>';
                    }
                    if ($data->status == '3') {
                        return '<button class="btn btn-info btn-sm">Approved</button>';
                    }
                    if ($data->status == '4') {
                        return '<button class="btn btn-secondary btn-sm">Dispatch</button>';
                    }
                })
                ->addColumn('action', function ($data) {

                    $actionBtn = '<div class="btn-group" role="group">
                    <a href="' . url('admin/outgoing_indent/details/' . $data->id) . '" class="edit btn btn-secondary btn-sm">Vetted</a>
                    </div>';
                    // if ($data->status == '2') {
                    //     $actionBtn = '<div class="btn-group" role="group">
                    //     <a href="' . url('admin/outgoing_indent/progress/' . $data->id) . '" class="edit btn btn-secondary btn-sm">Doc Status</a>
                    //     <button href="" class="edit btn btn-success btn-sm" disable>Completed</button>';
                    // } else {

                    // }


                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }
}