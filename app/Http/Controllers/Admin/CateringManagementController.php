<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CateringManagementList;
use App\Models\Hall;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CateringManagementController extends Controller
{
    public function index()
    {
        return view('backend.catering.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = CateringManagementList::leftJoin('halls', 'halls.id', 'catering_management_lists.hall_id')
            ->select('catering_management_lists.*', 'halls.name as hall_name');
 

            $query->orderBy('id', 'asc');

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $linkVar = 'admin/caterings/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/caterings/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                           <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
             
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $halls=Hall::all();
        return view('backend.catering.create' , compact('halls'));
    }

    public function store(Request $request)
    {
        
        $this->validate($request, [
            'hall_id' => 'required',
            'c_name' => 'required',
            'o_name' => 'required',
            'c_number' => 'required',

        ]);



        $event              = new CateringManagementList();
        $event->hall_id        = $request->hall_id;
        $event->company_name        = $request->c_name;
        $event->owner_name        = $request->o_name;
        $event->mobile_no_1        = $request->c_number;
        $event->mobile_no_2        = $request->a_number;
        $event->created_by = auth()->id();
        $event->updated_by = auth()->id();
        $event->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $caterings = CateringManagementList::find($id);
        $hall = Hall::pluck('name', 'id')->toArray();
        return view('backend.catering.edit')->with(compact('caterings','hall'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'c_name' => 'required',
            'o_name' => 'required',
            'c_number' => 'required',

        ]);

        $prev              = CateringManagementList::where('id', $request->edit_id)->first();
       

        $prev->hall_id        = $request->hall_id ?? $prev->hall_id;
        $prev->company_name        = $request->c_name ?? $prev->company_name;
        $prev->owner_name        = $request->o_name ?? $prev->owner_name;
        $prev->mobile_no_1        = $request->c_number ?? $prev->mobile_no_1;
        $prev->mobile_no_2        = $request->a_number ?? $prev->mobile_no_2;
        
        $prev->updated_by = auth()->id();

        if ($prev->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
    }

    public function delete($id)
    {
        $event = CateringManagementList::find($id);
        $event->delete();
        return response()->json(['success' => 'Done']);
    }
}
