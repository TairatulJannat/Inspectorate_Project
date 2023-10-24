<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventManagementList;
use App\Models\Hall;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventManagementController extends Controller
{
    public function index()
    {
        return view('backend.event_managment.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = EventManagementList::leftJoin('halls', 'halls.id', 'event_management_lists.hall_id')
            ->select('event_management_lists.*', 'halls.name as hall_name');

            $query->orderBy('id', 'asc');

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $linkVar = 'admin/events/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/events/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                           <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
                // ->addColumn('photo', function ($data) {
                //     $url = asset("uploads/member_Photograph/$data->photo");
                //     return '<img src=' . $url . ' border="0" width="40" class="img-rounded" align="center" />';
                // })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $halls=Hall::all();
        return view('backend.event_managment.create',compact('halls'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'c_name' => 'required',
            'o_name' => 'required',
            'c_number' => 'required',

        ]);



        $event              = new EventManagementList();

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
        $events = EventManagementList::find($id);
        $hall = Hall::pluck('name', 'id')->toArray();
        return view('backend.event_managment.edit')->with(compact('events' , 'hall'));
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

        $prev              = EventManagementList::where('id', $request->edit_id)->first();
       

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
        $event = EventManagementList::find($id);
        $event->delete();
        return response()->json(['success' => 'Done']);
    }
}
