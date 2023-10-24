<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingChangeRule;
use App\Models\Hall;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class BookingChangeRuleController extends Controller
{
    public function index()
    {
        return view('backend.bookingChangeRule.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = BookingChangeRule::leftJoin('halls', 'halls.id', 'booking_change_rules.hall_id')
                ->select('booking_change_rules.*', 'halls.id as halls_id', 'halls.name as hall_name')
                ->orderBy('halls_id', 'asc')->get();

            // $query->orderBy('hall_id', 'asc');

            return Datatables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == '1') {
                        return '<button class="btn btn-success btn-sm">Active</button>';
                    }
                    if ($data->status == '0') {
                        return '<button class="btn btn-danger btn-sm">Inactive</button>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $linkVar = 'admin/booking_change_rules/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/booking_change_rules/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                           <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function create()
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        return view('backend.bookingChangeRule.create')->with(compact('hall'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'min_date' => 'required',
            // 'max_date' => 'required',
            'reduce_amount_percentage' => 'required',
            'status' => 'required',
        ]);

        $bookingChangeRule              = new BookingChangeRule();
        $bookingChangeRule->hall_id        = $request->hall_id;

        $bookingChangeRule->is_fixed_amount        = $request->is_fixed_amount;
        if ($request->is_fixed_amount) {
            $bookingChangeRule->amount        = $request->amount;
        }

        $bookingChangeRule->is_fixed_percentage        = $request->is_fixed_percentage;
        if ($request->is_fixed_percentage) {
            $bookingChangeRule->percentage        = $request->percentage;
        }

        $bookingChangeRule->min_date        = $request->min_date;
        $bookingChangeRule->max_date        = $request->max_date;
        $bookingChangeRule->status = $request->status;
        $bookingChangeRule->created_by = auth()->id();
        $bookingChangeRule->updated_by = auth()->id();
        $bookingChangeRule->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $bookingChangeRule = BookingChangeRule::find($id);
        return view('backend.bookingChangeRule.edit')->with(compact('bookingChangeRule', 'hall'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
            'min_date' => 'required',
            // 'max_date' => 'required',
            'reduce_amount_percentage' => 'required',
            'status' => 'required',
        ]);

        $prev              = BookingChangeRule::where('id', $request->edit_id)->first();
        $prev->hall_id        = $request->hall_id ?? $prev->hall_id;
        $prev->is_fixed_amount        = $request->is_fixed_amount ?? $prev->is_fixed_amount;
        $prev->amount        = $request->amount ?? $prev->amount;
        $prev->is_fixed_percentage        = $request->is_fixed_percentage ?? $prev->is_fixed_percentage;
        $prev->percentage        = $request->percentage ?? $prev->percentage;
        $prev->min_date        = $request->min_date ?? $prev->min_date;
        $prev->max_date        = $request->max_date ?? $prev->max_date;
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
        $bookingChangeRule = BookingChangeRule::find($id);
        $bookingChangeRule->delete();
        return response()->json(['success' => 'Done']);
    }
}
