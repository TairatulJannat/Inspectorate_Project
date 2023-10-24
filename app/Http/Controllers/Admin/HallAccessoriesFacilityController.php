<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\HallAccessoriesFacility;
use App\Models\Hall;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class HallAccessoriesFacilityController extends Controller
{
    public function index()
    {
        return view('backend.hallAccessoriesFacility.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = HallAccessoriesFacility::leftJoin('halls', 'halls.id', 'hall_accessories_facilities.hall_id')
                ->leftJoin('floors', 'floors.id', 'hall_accessories_facilities.floor_id')
                ->select('hall_accessories_facilities.*', 'halls.id as halls_id', 'halls.name as hall_name', 'floors.name as floor_name')->orderBy('halls_id', 'asc')->orderBy('id', 'asc')->get();

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
                    $linkVar = 'admin/hall_accessories_facilities/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/hall_accessories_facilities/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

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
        $floor = [];
        return view('backend.hallAccessoriesFacility.create')->with(compact('hall', 'floor'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
        ]);

        $hallAccessoriesFacility              = new HallAccessoriesFacility();
        $hallAccessoriesFacility->hall_id        = $request->hall_id;
        $hallAccessoriesFacility->floor_id        = $request->floor_id;
        $hallAccessoriesFacility->num_of_extra_room        = $request->num_of_extra_room;
        $hallAccessoriesFacility->num_of_chair = $request->num_of_chair;
        $hallAccessoriesFacility->num_of_table = $request->num_of_table;
        $hallAccessoriesFacility->num_of_sofa = $request->num_of_sofa;
        $hallAccessoriesFacility->car_parking_limit = $request->car_parking_limit;
        $hallAccessoriesFacility->created_by = auth()->id();
        $hallAccessoriesFacility->updated_by = auth()->id();
        $hallAccessoriesFacility->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hallAccessoriesFacility = HallAccessoriesFacility::find($id);
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $floor = Floor::where('hall_id', $hallAccessoriesFacility->hall_id)
            ->where('status', '1')->pluck('name', 'id')->toArray();
        return view('backend.hallAccessoriesFacility.edit')->with(compact('hallAccessoriesFacility', 'hall', 'floor'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
        ]);

        $prev              = HallAccessoriesFacility::where('id', $request->edit_id)->first();
        $prev->hall_id        = $request->hall_id ?? $prev->hall_id;
        $prev->floor_id        = $request->floor_id ?? $prev->floor_id;
        $prev->num_of_extra_room        = $request->num_of_extra_room ?? $prev->num_of_extra_room;
        $prev->num_of_chair        = $request->num_of_chair ?? $prev->num_of_chair;
        $prev->num_of_table = $request->num_of_table ?? $prev->num_of_table;
        $prev->num_of_sofa = $request->num_of_sofa ?? $prev->num_of_sofa;
        $prev->car_parking_limit = $request->car_parking_limit ?? $prev->car_parking_limit;
        $prev->updated_by = auth()->id();

        if ($prev->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
    }

    public function delete($id)
    {
        $hallAccessoriesFacility = HallAccessoriesFacility::find($id);
        $hallAccessoriesFacility->delete();
        return response()->json(['success' => 'Done']);
    }
}
