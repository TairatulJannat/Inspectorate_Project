<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OthersPrice;
use App\Models\Hall;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class OthersPriceController extends Controller
{
    public function index()
    {
        return view('backend.othersPrice.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = OthersPrice::leftJoin('halls', 'halls.id', 'others_prices.hall_id')
                ->select('others_prices.*', 'halls.id as halls_id', 'halls.name as hall_name')
                ->orderBy('halls_id', 'asc')->get();

            // $query->orderBy('hall_id', 'asc');

            return Datatables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $linkVar = 'admin/others_prices/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/others_prices/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                           <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        return view('backend.othersPrice.create')->with(compact('hall'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
        ]);

        $othersPrice                                    = new OthersPrice();
        $othersPrice->hall_id                           = $request->hall_id;
        $othersPrice->security_amount                   = $request->security_amount;
        $othersPrice->extra_amount_per_hour             = $request->extra_amount_per_hour;
        $othersPrice->service_charge_for_defence        = $request->service_charge_for_defence;
        $othersPrice->service_charge_for_non_defence    = $request->service_charge_for_non_defence;
        $othersPrice->vat_in_percentage                 = $request->vat_in_percentage;
        $othersPrice->created_by                        = auth()->id();
        $othersPrice->updated_by                        = auth()->id();
        $othersPrice->save();
        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $hall = Hall::where('status', '1')->pluck('name', 'id')->toArray();
        $othersPrice = OthersPrice::find($id);
        return view('backend.othersPrice.edit')->with(compact('othersPrice', 'hall'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'hall_id' => 'required',
        ]);

        $prev                                   = OthersPrice::where('id', $request->edit_id)->first();
        $prev->hall_id                          = $request->hall_id ?? $prev->hall_id;
        $prev->security_amount                  = $request->security_amount;
        $prev->extra_amount_per_hour            = $request->extra_amount_per_hour;
        $prev->service_charge_for_defence       = $request->service_charge_for_defence;
        $prev->service_charge_for_non_defence   = $request->service_charge_for_non_defence;
        $prev->vat_in_percentage                = $request->vat_in_percentage;
        $prev->updated_by                       = auth()->id();

        if ($prev->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
    }

    public function delete($id)
    {
        $othersPrice = OthersPrice::find($id);
        $othersPrice->delete();
        return response()->json(['success' => 'Done']);
    }
}
