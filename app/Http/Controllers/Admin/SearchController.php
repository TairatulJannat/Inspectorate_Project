<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocType;
use App\Models\DocumentTrack;
use App\Models\Indent;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $doc_types = DocType::all();
        return view('backend.search.index', compact('doc_types'));
    }

    public function searchView(Request $request)
    {
        $docTypeId = $request->docTypeId;
        $docReferenceNumber = $request->docReferenceNumber;

        // dd($data);
        if ($docTypeId == 3) {

            $data_seen = DocumentTrack::where('doc_type_id', $docTypeId)->where('doc_reference_number',  $docReferenceNumber)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 1)
            ->select(
                'document_tracks.*',
                'sender_designation.name as sender_designation_name',
                'receiver_designation.name as receiver_designation_name'
            )
            ->get();

            $data_vetted = DocumentTrack::where('doc_type_id', $docTypeId)->where('doc_reference_number',  $docReferenceNumber)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 2)
            ->select(
                'document_tracks.*',
                'sender_designation.name as sender_designation_name',
                'receiver_designation.name as receiver_designation_name'
            )
            ->get();
            $data_approved = DocumentTrack::where('doc_type_id', $docTypeId)->where('doc_reference_number',  $docReferenceNumber)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 3)
            ->select(
                'document_tracks.*',
                'sender_designation.name as sender_designation_name',
                'receiver_designation.name as receiver_designation_name'
            )
            ->get();
            $data_dispatch = DocumentTrack::where('doc_type_id', $docTypeId)->where('doc_reference_number',  $docReferenceNumber)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 4)
            ->select(
                'document_tracks.*',
                'sender_designation.name as sender_designation_name',
                'receiver_designation.name as receiver_designation_name'
            )
            ->get();

            if ($data_seen) {
                $details = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('additional_documents', 'indents.additional_documents', '=', 'additional_documents.id')
                    ->leftJoin('fin_years', 'indents.fin_year_id', '=', 'fin_years.id')
                    ->leftJoin('items', 'indents.item_id', '=', 'items.id')
                    ->select(
                        'indents.*',
                        'item_types.name as item_type_name',
                        'indents.*',
                        'dte_managments.name as dte_managment_name',
                        'items.name as item_name',
                        'additional_documents.name as additional_documents_name',
                        'fin_years.year as fin_year_name'
                    )->where('indents.reference_no', $docReferenceNumber)
                    ->first();
                return response()->json(['details' => $details, 'data_seen' => $data_seen, 'data_vetted'=>$data_vetted,'data_approved'=>$data_approved, 'data_dispatch'=>$data_dispatch]);
            } elseif (!$data_seen) {
                return response()->json(['error' => 'Document not found'], 404);
            }
        }
    }
}
