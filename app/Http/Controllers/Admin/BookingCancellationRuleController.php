<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingCancellationRule;
use App\Models\Hall;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class BookingCancellationRuleController extends Controller
{
    public function index()
    {
        return view('backend.bookingCancellationRule.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = BookingCancellationRule::leftJoin('halls', 'halls.id', 'booking_cancellation_rules.hall_id')
                ->select('booking_cancellation_rules.*', 'halls.id as halls_id', 'halls.name as hall_name')
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
                    $linkVar = 'admin/booking_cancellation_rules/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/booking_cancellation_rules/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

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
        return view('backend.bookingCancellationRule.create')->with(compact('hall'));
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

        $bookingCancellationRule              = new BookingCancellationRule();
        $bookingCancellationRule->hall_id        = $request->hall_id;
        $bookingCancellationRule->reduce_amount_percentage        = $request->reduce_amount_percentage;
        $bookingCancellationRule->min_date        = $request->min_date;
        $bookingCancellationRule->max_date        = $request->max_date;
        $bookingCancellationRule->status = $request->status;
        $bookingCancellationRule->created_by = auth()->id();
        $bookingCancellationRule->updated_by = auth()->id();
        $bookingCancellationRule->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $bookingCancellationRule = BookingCancellationRule::find($id);
        return view('backend.bookingCancellationRule.edit')->with(compact('bookingCancellationRule', 'hall'));
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

        $prev              = BookingCancellationRule::where('id', $request->edit_id)->first();
        $prev->hall_id        = $request->hall_id ?? $prev->hall_id;
        $prev->min_date        = $request->min_date ?? $prev->min_date;
        $prev->max_date        = $request->max_date ?? $prev->max_date;
        $prev->reduce_amount_percentage        = $request->reduce_amount_percentage ?? $prev->reduce_amount_percentage;
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
        $bookingCancellationRule = BookingCancellationRule::find($id);
        $bookingCancellationRule->delete();
        return response()->json(['success' => 'Done']);
    }
}
