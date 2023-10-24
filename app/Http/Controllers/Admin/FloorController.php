<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\Hall;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class FloorController extends Controller
{
    public function index()
    {
        return view('backend.floor.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = Floor::leftJoin('halls', 'halls.id', 'floors.hall_id')->select('floors.*', 'halls.id as halls_id', 'halls.name as hall_name')->orderBy('halls_id', 'asc')->get();

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
                    $linkVar = 'admin/floor/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/floor/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

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
        return view('backend.floor.create')->with(compact('hall'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'status' => 'required',
        ]);

        $imageOneName = '';
        if ($request->file('image_one')) {
            $imageOne     = $request->file('image_one');
            $imageOneName = time() . '.' . $imageOne->getClientOriginalName();
            $imageOne->move(public_path('/assets/backend/images/hall'), $imageOneName);
        }

        $imageTwoName = '';
        if ($request->file('image_two')) {
            $imageTwo     = $request->file('image_two');
            $imageTwoName = time() . '.' . $imageTwo->getClientOriginalName();
            $imageTwo->move(public_path('/assets/backend/images/hall'), $imageTwoName);
        }

        $imageThreeName = '';
        if ($request->file('image_three')) {
            $imageThree     = $request->file('image_three');
            $imageThreeName = time() . '.' . $imageThree->getClientOriginalName();
            $imageThree->move(public_path('/assets/backend/images/hall'), $imageThreeName);
        }

        $floor              = new Floor();
        $floor->hall_id        = $request->hall_id;
        $floor->name        = $request->name;
        $floor->description        = $request->description;
        $floor->image_one = $imageOneName ?? '';
        $floor->image_two = $imageTwoName ?? '';
        $floor->image_three = $imageThreeName ?? '';
        $floor->capacity = $request->capacity;
        $floor->status = $request->status;
        $floor->created_by = auth()->id();
        $floor->updated_by = auth()->id();
        $floor->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $floor = Floor::find($id);
        return view('backend.floor.edit')->with(compact('floor', 'hall'));
        // return response()->json(['data' => $floor]);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'hall_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'status' => 'required',
        ]);

        $prev              = Floor::where('id', $request->edit_id)->first();

        $imageOneName = $prev->image_one;
        if ($request->file('image_one')) {
            $imageOne     = $request->file('image_one');
            $imageOneName = time() . '.' . $imageOne->getClientOriginalName();
            $imageOne->move(public_path('/assets/backend/images/hall'), $imageOneName);
        }

        $imageTwoName = $prev->image_two;
        if ($request->file('image_two')) {
            $imageTwo     = $request->file('image_two');
            $imageTwoName = time() . '.' . $imageTwo->getClientOriginalName();
            $imageTwo->move(public_path('/assets/backend/images/hall'), $imageTwoName);
        }

        $imageThreeName = $prev->image_three;
        if ($request->file('image_three')) {
            $imageThree     = $request->file('image_three');
            $imageThreeName = time() . '.' . $imageThree->getClientOriginalName();
            $imageThree->move(public_path('/assets/backend/images/hall'), $imageThreeName);
        }

        $prev->hall_id        = $request->hall_id ?? $prev->hall_id;
        $prev->name        = $request->name ?? $prev->name;
        $prev->description        = $request->description ?? $prev->description;
        $prev->image_one = $imageOneName ?? $prev->image_one;
        $prev->image_two = $imageTwoName ?? $prev->image_two;
        $prev->image_three = $imageThreeName ?? $prev->image_three;
        $prev->capacity        = $request->capacity ?? $prev->capacity;
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
        $floor = Floor::find($id);
        $floor->delete();
        return response()->json(['success' => 'Done']);
    }
}
