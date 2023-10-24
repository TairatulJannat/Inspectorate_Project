<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Hall;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    public function index()
    {
        return view('backend.settings.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = Settings::leftJoin('halls', 'halls.id', 'settings.hall_id')
                ->select('settings.*', 'halls.id as halls_id', 'halls.name as hall_name')
                ->orderBy('halls_id', 'asc')->get();

            // $query->orderBy('hall_id', 'asc');

            return Datatables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('photo', function ($data) {
                    if ($data->logo) {
                        $url = asset("assets/backend/images/settings/$data->logo");
                    } else {
                        $url = asset("assets/backend/images/no.jpg");
                    }
                    return '<img src=' . $url . ' border="0" width="70" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function ($data) {
                    $linkVar = 'admin/settings/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/settings/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                           <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['photo', 'action'])
                ->make(true);
        }
    }

    public function create()
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        return view('backend.settings.create')->with(compact('hall'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required|unique:settings',
        ]);

        $imageOneName = '';
        if ($request->file('logo')) {
            $imageOne     = $request->file('logo');
            $imageOneName = time() . '.' . $imageOne->getClientOriginalName();
            $imageOne->move(public_path('/assets/backend/images/settings'), $imageOneName);
        }

        $settings                       = new Settings();
        $settings->hall_id              = $request->hall_id;
        $settings->logo                 = $imageOneName ?? '';
        $settings->email                = $request->email;
        $settings->contact_information  = $request->contact_information;
        $settings->location             = $request->location;
        $settings->facebook_link        = $request->facebook_link;
        $settings->instagram_link       = $request->instagram_link;
        $settings->youtube_link         = $request->youtube_link;
        $settings->about_us             = $request->about_us;
        $settings->policy               = $request->policy;
        $settings->created_by           = auth()->id();
        $settings->updated_by           = auth()->id();
        $settings->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $settings = Settings::find($id);
        return view('backend.settings.edit')->with(compact('settings', 'hall'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'hall_id' => 'required:settings,hall_id,' . $request->edit_id,
        ]);

        $prev              = Settings::where('id', $request->edit_id)->first();

        $imageOneName = $prev->logo;
        if ($request->file('logo')) {
            $imageOne     = $request->file('logo');
            $imageOneName = time() . '.' . $imageOne->getClientOriginalName();
            $imageOne->move(public_path('/assets/backend/images/settings'), $imageOneName);
        }

        $prev->hall_id              = $request->hall_id ?? $prev->hall_id;
        $prev->logo                 = $imageOneName;
        $prev->email                = $request->email;
        $prev->contact_information  = $request->contact_information;
        $prev->location             = $request->location;
        $prev->facebook_link        = $request->facebook_link;
        $prev->instagram_link       = $request->instagram_link;
        $prev->youtube_link         = $request->youtube_link;
        $prev->about_us             = $request->about_us;
        $prev->policy               = $request->policy;
        $prev->updated_by           = auth()->id();

        if ($prev->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
    }

    public function delete($id)
    {
        $settings = Settings::find($id);
        $settings->delete();
        return response()->json(['success' => 'Done']);
    }
}
