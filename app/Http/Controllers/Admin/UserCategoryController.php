<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserCategory;
use App\Models\Hall;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class UserCategoryController extends Controller
{
    public function index()
    {
        return view('backend.userCategory.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = UserCategory::leftJoin('halls', 'halls.id', 'user_categories.hall_id')->select('user_categories.*', 'halls.id as halls_id', 'halls.name as hall_name')->orderBy('halls_id', 'asc')->get();

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
                    $linkVar = 'admin/user_category/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/user_category/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

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
        return view('backend.userCategory.create')->with(compact('hall'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'status' => 'required',
        ]);

        $userCategory              = new UserCategory();
        $userCategory->hall_id        = $request->hall_id;
        $userCategory->name        = $request->name;
        $userCategory->code        = $request->code;
        $userCategory->description = $request->description;
        $userCategory->status = $request->status;
        $userCategory->created_by = auth()->id();
        $userCategory->updated_by = auth()->id();
        $userCategory->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $userCategory = UserCategory::find($id);
        return view('backend.userCategory.edit')->with(compact('userCategory', 'hall'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'status' => 'required',
        ]);

        $prev              = UserCategory::where('id', $request->edit_id)->first();
        $prev->hall_id        = $request->hall_id ?? $prev->hall_id;
        $prev->name        = $request->name ?? $prev->name;
        $prev->code        = $request->code ?? $prev->code;
        $prev->description        = $request->description ?? $prev->description;
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
        $userCategory = UserCategory::find($id);
        $userCategory->delete();
        return response()->json(['success' => 'Done']);
    }
}
