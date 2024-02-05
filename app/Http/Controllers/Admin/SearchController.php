<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocType;
use App\Models\DocumentTrack;
use App\Models\FinancialYear;
use App\Models\Indent;
use App\Models\Offer;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $doc_types = DocType::all();
        $financial_year = FinancialYear::all();
        return view('backend.search.index', compact('doc_types', 'financial_year'));
    }



    public function all_data(Request $request)
    {
        try {


            $reference_no = $request->reference_no ? $request->reference_no : '';
            $doc_type_id =  $request->doc_type_id ? $request->doc_type_id : '';
            $fy = $request->fy ? $request->fy : '';

            $data = null;
            $doc_type = DocType::find($doc_type_id);
            $modelClass = 'App\\Models\\' . $doc_type->name;

            if (class_exists($modelClass)) {
                $data = $modelClass::all();
            } else {
                throw ValidationException::withMessages(['doc_type' => 'Invalid document type.']);
            }

            // Process $data further if needed

            // Return or use $data as needed
            return response()->json(['data' => $data, 'docTypeId' => $doc_type_id]);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function searchView(Request $request)

    {

        $docTypeId = $request->docTypeId;
        $docReferenceNumber = $request->docReferenceNumber;
        $doc_type = DocType::find($docTypeId);
        $modelClass = 'App\\Models\\' . $doc_type->name;
        $Model = "";
        try {
            $data_seen = DocumentTrack::where('doc_type_id', $docTypeId)->where('doc_reference_number', $docReferenceNumber)
                ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
                ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
                ->where('track_status', 1)
                ->whereNot(function ($query) {
                    $query->where('sender_designation.id', 7)
                        ->where('receiver_designation.id', 5);
                })
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
                ->whereNot(function ($query) {
                    $query->where('sender_designation.id', 5)
                        ->where('receiver_designation.id', 3);
                })
                ->whereNot(function ($query) {
                    $query->where('sender_designation.id', 7)
                        ->where('receiver_designation.id', 3);
                })
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

            if ($docTypeId == 3) {
                $details = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('additional_documents', 'indents.additional_documents', '=', 'additional_documents.id')
                    ->leftJoin('fin_years', 'indents.fin_year_id', '=', 'fin_years.id')
                    ->leftJoin('items', 'indents.item_id', '=', 'items.id')
                    ->select(
                        'indents.*',
                        'item_types.name as item_type_name',
                        'dte_managments.name as dte_managment_name',
                        'items.name as item_name',
                        'additional_documents.name as additional_documents_name',
                        'fin_years.year as fin_year_name'
                    )->where('indents.reference_no', $docReferenceNumber)
                    ->first();
            } elseif ($docTypeId == 5) {
                $details = Offer::leftJoin('item_types', 'offers.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'offers.sender', '=', 'dte_managments.id')
                    ->leftJoin('additional_documents', 'offers.additional_documents', '=', 'additional_documents.id')
                    ->leftJoin('fin_years', 'offers.fin_year_id', '=', 'fin_years.id')
                    ->leftJoin('items', 'offers.item_id', '=', 'items.id')
                    ->select(
                        'offers.*',
                        'item_types.name as item_type_name',
                        'offers.*',
                        'dte_managments.name as dte_managment_name',
                        'items.name as item_name',
                        'additional_documents.name as additional_documents_name',
                        'fin_years.year as fin_year_name'
                    )->where('offers.reference_no', $docReferenceNumber)
                    ->first();
            }



            if ($details) {
                return response()->json(
                    [
                        'details' => $details,
                        'data_seen' => $data_seen,
                        'data_vetted' => $data_vetted,
                        'data_approved' => $data_approved,
                        'data_dispatch' => $data_dispatch,
                        'docTypeId' => $docTypeId,
                        'success' => "Search document found"
                    ],
                    200
                );
            } else {
                return response()->json(['error' => 'Document Not Found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Document Not Found'], 500);
        }
    }
}
