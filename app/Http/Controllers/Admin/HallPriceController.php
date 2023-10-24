<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\HallPrice;
use App\Models\Hall;
use App\Models\Shift;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class HallPriceController extends Controller
{
    public function index(Request $request)
    {
        $hall_name = $request->hall_name ?? "";
        $user_categories = $request->user_categories ?? "";
        $shift = $request->shift ?? "";

        $halls = Hall::all();
        $user_lists = UserCategory::all();
        return view('backend.hallPrice.index', compact('halls', 'user_lists', 'hall_name', 'user_categories', 'shift'));
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = HallPrice::leftJoin('halls', 'halls.id', 'hall_prices.hall_id')
                // ->leftJoin('floors', 'floors.id', 'hall_prices.floor_id')
                ->leftJoin('shifts', 'shifts.id', 'hall_prices.shift_id')
                ->select('hall_prices.*', 'halls.id as halls_id', 'halls.name as hall_name', 'shifts.name as shift_name')
                ->orderBy('halls_id', 'asc')
                ->get();

            // $query->orderBy('hall_id', 'asc');
            if ($request->hall_name) {
                $hall_id = Hall::where('name', 'like', '%' . $request->hall_name . '%')->pluck('id');
                 $query = $query->whereIn('hall_id', $hall_id);
            }
            if ($request->shift) {
                $shift_id = Shift::where('name', 'like', '%' . $request->shift . '%')->pluck('id');
                 $query = $query->whereIn('shift_id', $shift_id);
            }
            if($request->user_categories){
                $userCategory = UserCategory::whereIn('id', json_decode($request->user_categories))->select('name')->get();
                
            }

            return Datatables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('floor', function ($data) {
                    if ($data->floor_id) {
                        $floor = Floor::whereIn('id', json_decode($data->floor_id))->select('name')->get();
                        $floorName = [];
                        if ($floor) {
                            foreach ($floor as $key => $value) {
                                array_push($floorName, $value->name);
                            }
                        }
                        return $floorName;
                    } else {
                        return '';
                    }
                })
                ->addColumn('user_category', function ($data) {
                    if ($data->user_category_id) {
                        $userCategory = UserCategory::whereIn('id', json_decode($data->user_category_id))->select('name')->get();
                        $userCategoryName = [];
                        if ($userCategory) {
                            foreach ($userCategory as $key => $value) {
                                array_push($userCategoryName, $value->name);
                            }
                        }
                        return $userCategoryName;
                    } else {
                        return '';
                    }
                })
                ->addColumn('months', function ($data) {
                    if ($data->months) {
                        return json_decode($data->months);
                    } else {
                        return '';
                    }
                })
                ->addColumn('specify_event', function ($data) {
                    if ($data->specify_event == 'on') {
                        return '<button class="btn btn-success btn-sm">On</button>';
                    } else {
                        return '<button class="btn btn-secondary btn-sm">Off</button>';
                    }
                })
                ->addColumn('specify_month', function ($data) {
                    if ($data->specify_month == 'on') {
                        return '<button class="btn btn-success btn-sm">On</button>';
                    } else {
                        return '<button class="btn btn-secondary btn-sm">Off</button>';
                    }
                })
                ->addColumn('specify_ramadan', function ($data) {
                    if ($data->specify_ramadan == 'on') {
                        return '<button class="btn btn-success btn-sm">On</button>';
                    } else {
                        return '<button class="btn btn-secondary btn-sm">Off</button>';
                    }
                })
                ->addColumn('specify_holiday', function ($data) {
                    if ($data->specify_holiday == 'on') {
                        return '<button class="btn btn-success btn-sm">On</button>';
                    } else {
                        return '<button class="btn btn-secondary btn-sm">Off</button>';
                    }
                })
                ->addColumn('specify_shift_charge', function ($data) {
                    if ($data->specify_shift_charge == 'on') {
                        return '<button class="btn btn-success btn-sm">On</button>';
                    } else {
                        return '<button class="btn btn-secondary btn-sm">Off</button>';
                    }
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
                    $linkVar = 'admin/hall_price/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/hall_price/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                           <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['months', 'status', 'action', 'specify_event', 'specify_month', 'specify_ramadan', 'specify_holiday', 'specify_shift_charge', 'floor', 'user_category'])
                ->make(true);
        }
    }

    public function create()
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $floor = $userCategory = $shift = [];
        return view('backend.hallPrice.create')->with(compact('hall', 'floor', 'userCategory', 'shift'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'floor_id' => 'required',
            'user_category_id' => 'required',
            // 'specify_event' => 'required|in:on,off',
            'event_name' => 'required_if:specify_event,on',
            // 'specify_month' => 'required|in:on,off',
            'months' => 'required_if:specify_month,on',
            // 'specify_ramadan' => 'required|in:on,off',
            // 'specify_shift_charge' => 'required|in:on,off',
            'shift_id' => 'required_if:specify_shift_charge,on',
            'price' => 'required',
            'status' => 'required',
        ]);

        $floor_id = '';
        if ($request->floor_id) {
            $floor_id = json_encode($request->floor_id);
        }

        $user_category_id = '';
        if ($request->user_category_id) {
            $user_category_id = json_encode($request->user_category_id);
        }

        $months = '';
        if ($request->months) {
            $months = json_encode($request->months);
        }

        $hallPrice                      = new HallPrice();
        $hallPrice->hall_id             = $request->hall_id;
        $hallPrice->floor_id            = $floor_id;
        $hallPrice->user_category_id    = $user_category_id;
        $hallPrice->specify_event       = $request->specify_event;
        $hallPrice->event_name          = $request->event_name;
        $hallPrice->specify_month       = $request->specify_month;
        $hallPrice->months              = $months;
        $hallPrice->specify_ramadan     = $request->specify_ramadan;
        $hallPrice->specify_holiday     = $request->specify_holiday;
        $hallPrice->specify_shift_charge = $request->specify_shift_charge;
        $hallPrice->shift_id            = $request->shift_id;
        $hallPrice->price               = $request->price;
        $hallPrice->status              = $request->status;
        $hallPrice->created_by          = auth()->id();
        $hallPrice->updated_by          = auth()->id();

        // dd($request->all());
        $hallPrice->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hallPrice = HallPrice::find($id);

        $floor_id = [];
        if ($hallPrice->floor_id) {
            $floor_id = json_decode($hallPrice->floor_id);
        }

        $user_category_id = [];
        if ($hallPrice->user_category_id) {
            $user_category_id = json_decode($hallPrice->user_category_id);
        }

        $months = [];
        if ($hallPrice->months) {
            $months = json_decode($hallPrice->months);
        }

        // dd($months);
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $floor = Floor::where('hall_id', $hallPrice->hall_id)
            ->where('status', '1')->pluck('name', 'id')->toArray();
        $userCategory = UserCategory::where('hall_id', $hallPrice->hall_id)
            ->where('status', '1')->pluck('name', 'id')->toArray();
        $shift = Shift::where('hall_id', $hallPrice->hall_id)
            ->where('status', '1')->pluck('name', 'id')->toArray();
        return view('backend.hallPrice.edit')->with(compact('hallPrice', 'hall', 'floor', 'userCategory', 'shift', 'months', 'floor_id', 'user_category_id'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'floor_id' => 'required',
            'user_category_id' => 'required',
            // 'specify_event' => 'required|in:on,off',
            'event_name' => 'required_if:specify_event,on',
            // 'specify_month' => 'required|in:on,off',
            'months' => 'required_if:specify_month,on',
            // 'specify_ramadan' => 'required|in:on,off',
            // 'specify_shift_charge' => 'required|in:on,off',
            'shift_id' => 'required_if:specify_shift_charge,on',
            'price' => 'required',
            'status' => 'required',
        ]);

        $floor_id = '';
        if ($request->floor_id) {
            $floor_id = json_encode($request->floor_id);
        }

        $user_category_id = '';
        if ($request->user_category_id) {
            $user_category_id = json_encode($request->user_category_id);
        }

        $months = '';
        if ($request->months) {
            $months = json_encode($request->months);
        }

        $prev                        = HallPrice::where('id', $request->edit_id)->first();
        $prev->hall_id               = $request->hall_id ?? $prev->hall_id;
        $prev->floor_id              = $floor_id;
        $prev->user_category_id      = $user_category_id;
        $prev->specify_event         = $request->specify_event;
        $prev->event_name            = $request->event_name;
        $prev->specify_month         = $request->specify_month;
        $prev->months                = $months;
        $prev->specify_ramadan       = $request->specify_ramadan;
        $prev->specify_holiday       = $request->specify_holiday;
        $prev->specify_shift_charge  = $request->specify_shift_charge;
        $prev->shift_id              = $request->shift_id;
        $prev->price                 = $request->price ?? $prev->price;
        $prev->status                = $request->status ?? $prev->status;
        $prev->updated_by = auth()->id();

        if ($prev->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
    }

    public function delete($id)
    {
        $hallPrice = HallPrice::find($id);
        $hallPrice->delete();
        return response()->json(['success' => 'Done']);
    }
}
