<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\CateringManagementList;
use App\Models\EventManagementList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BookingController extends Controller
{
    public function index()
    {

        return view("backend.booking.index");
    }
    public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = Booking::all();

            $query = DB::table('bookings')
                ->leftJoin('halls', 'bookings.hall_id', '=', 'halls.id')
                ->leftJoin('floors', 'bookings.floor_id', '=', 'floors.id')
                ->leftJoin('guests', 'bookings.guest_id', '=', 'guests.id')
                ->leftJoin('hall_prices', 'bookings.hall_pricing_package_id', '=', 'hall_prices.id')
                ->select('bookings.*', 'halls.name as hall_name', 'floors.name as floor_name', 'guests.name as guest_name', 'hall_prices.price as hall_booking_price')
                ->get();



            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn("hall_name", function ($data) {
                    if ($data->hall_name) {
                        return $data->hall_name;
                    } else {
                        return '';
                    }
                })
                ->addColumn("guest_name", function ($data) {
                    if ($data->guest_name) {
                        return $data->guest_name;
                    } else {
                        return '';
                    }
                })
                ->addColumn("floor_name", function ($data) {
                    if ($data->floor_name) {
                        return $data->floor_name;
                    } else {
                        return '';
                    }
                })
                ->addColumn("action", function ($data) {

                    $actionBtn = '
                    <div class="mb-1">
                    <a href="' . url('admin/bookings/details_create/' . $data->id) . '" class="edit btn btn-outline-info btn-sm">Add Details</a>
                    </div>
                    <div class="btn-group mb-1">
                    <a href="' . url('admin/booking_voucher/create/' . $data->id) . '" class="edit btn btn-outline-info btn-sm">Payments</a>
                    <a href="' . url('admin/booking_voucher/create/' . $data->id) . '" class="edit btn btn-outline-info btn-sm">Voucher</a>
                    </div>
                    <div class="btn-group" role="group">
                           
                            <a href="" class="edit btn btn-outline-success btn-sm">Edit</a>

                            <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="">Delete</a>';
                    return $actionBtn;
                })

                ->rawColumns(["action"])
                ->make(true);
        }
    }

    public function booking_details($id){
        $booking_id=$id;
        $booking=Booking::find($id);
        if( $booking){
            $hall_id=$booking->hall_id;
        }

        $caterings=CateringManagementList::all();
        $events=EventManagementList::where('hall_id',$hall_id)->get();

        return view("backend.booking_details.create" ,compact('booking_id','caterings', 'events'));
    }
    public function details_store(Request $request){
        $request->validate([
            'guest_number'=>'required',
            'catering_management_id'=>'required',
            'event_management_id'=>'required'
        ]);
        $booking_details=new BookingDetail();

        $booking_details->booking_id=$request->booking_id;
        $booking_details->guest_number=$request->guest_number;
        $booking_details->catering_management_id=$request->catering_management_id;
        $booking_details->event_management_id=$request->event_management_id;
        $booking_details->created_by=auth()->id();
        $booking_details->updated_by=auth()->id();

        $booking_details->save();
        return response()->json(['success' => 'Done']);

    }
}
