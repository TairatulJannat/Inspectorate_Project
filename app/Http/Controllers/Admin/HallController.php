<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\Hall;
use App\Models\Shift;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class HallController extends Controller
{
    public function index()
    {
        return view('backend.hall.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = Hall::query();

            $query->orderBy('id', 'asc');

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
                    $linkVar = 'admin/hall/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/hall/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

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
        return view('backend.hall.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
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

        $hall              = new Hall();
        $hall->name        = $request->name;
        $hall->description        = $request->description;
        $hall->image_one = $imageOneName ?? '';
        $hall->image_two = $imageTwoName ?? '';
        $hall->image_three = $imageThreeName ?? '';
        $hall->location = $request->location;
        $hall->status = $request->status;
        $hall->created_by = auth()->id();
        $hall->updated_by = auth()->id();
        $hall->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hall = Hall::find($id);
        return view('backend.hall.edit')->with(compact('hall'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'status' => 'required',
        ]);

        $prev              = Hall::where('id', $request->edit_id)->first();
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

        $prev->name        = $request->name ?? $prev->name;
        $prev->description        = $request->description ?? $prev->description;
        $prev->image_one = $imageOneName ?? $prev->image_one;
        $prev->image_two = $imageTwoName ?? $prev->image_two;
        $prev->image_three = $imageThreeName ?? $prev->image_three;
        $prev->location = $request->location ?? $prev->location;
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
        $hall = Hall::find($id);
        $hall->delete();
        return response()->json(['success' => 'Done']);
    }

    public function get_floor(Request $request)
    {
        $floors = Floor::where('hall_id', $request->hall_id)
            ->where('status', '1')->get();
        return response()->json(['data' => $floors]);
    }

    public function get_user_category(Request $request)
    {
        $userCategory = UserCategory::where('hall_id', $request->hall_id)
            ->where('status', '1')->get();
        return response()->json(['data' => $userCategory]);
    }

    public function get_shift(Request $request)
    {
        $shift = Shift::where('hall_id', $request->hall_id)
            ->where('status', '1')->get();
        return response()->json(['data' => $shift]);
    }
}
