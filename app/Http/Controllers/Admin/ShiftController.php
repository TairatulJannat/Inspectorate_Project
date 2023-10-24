<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\Hall;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ShiftController extends Controller
{
    public function index()
    {
        return view('backend.shift.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = Shift::leftJoin('halls', 'halls.id', 'shifts.hall_id')->select('shifts.*', 'halls.id as halls_id', 'halls.name as hall_name')->orderBy('halls_id', 'asc')->get();

            // $query->orderBy('hall_id', 'asc');

            return Datatables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('photo', function ($data) {
                    if ($data->image_one) {
                        $url = asset("assets/backend/images/hall/$data->image_one");
                    } else {
                        $url = asset("assets/backend/images/no.jpg");
                    }
                    return '<img src=' . $url . ' border="0" width="70" class="img-rounded" align="center" />';
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == '1') {
                        return '<button class="btn btn-success btn-sm">Active</button>';
                    }
                    if ($data->status == '0') {
                        return '<button class="btn btn-danger btn-sm">Inactive</button>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $linkVar = 'admin/shift/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/shift/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                           <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
                // ->addColumn('photo', function ($data) {
                //     $url = asset("uploads/member_Photograph/$data->photo");
                //     return '<img src=' . $url . ' border="0" width="40" class="img-rounded" align="center" />';
                // })
                ->rawColumns(['photo', 'status', 'action'])
                ->make(true);
        }
    }

    public function create()
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        return view('backend.shift.create')->with(compact('hall'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required',
        ]);

        $shift              = new Shift();
        $shift->hall_id        = $request->hall_id;
        $shift->name        = $request->name;
        $shift->start_time        = $request->start_time;
        $shift->end_time = $request->end_time;
        $shift->status = $request->status;
        $shift->created_by = auth()->id();
        $shift->updated_by = auth()->id();
        $shift->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $shift = Shift::find($id);
        return view('backend.shift.edit')->with(compact('shift', 'hall'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required',
        ]);

        $prev              = Shift::where('id', $request->edit_id)->first();
        $prev->hall_id        = $request->hall_id ?? $prev->hall_id;
        $prev->name        = $request->name ?? $prev->name;
        $prev->start_time        = $request->start_time ?? $prev->start_time;
        $prev->end_time        = $request->end_time ?? $prev->end_time;
        $prev->status = $request->status ?? $prev->status;
        $prev->updated_by = auth()->id();

        if ($prev->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
    }

    public function delete($id)
    {
        $shift = Shift::find($id);
        $shift->delete();
        return response()->json(['success' => 'Done']);
    }
}
