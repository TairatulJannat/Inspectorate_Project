<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\EventManagementList;
use App\Models\Guest;
use App\Models\Hall;
use App\Models\OthersPrice;
use Illuminate\Http\Request;

class BookingVoucherController extends Controller
{
   public function create($id){
    $booking_id= $id;
    $booking = Booking::where('id', $booking_id)->first();
    $hall = Hall::where('id', $booking->hall_id)->first();
    $guest=Guest::where('id', $booking->guest_id)->first(); 
    $others_price=OthersPrice::where('hall_id', $booking->hall_id)->first();
    $booking_details = BookingDetail::where('booking_id', $booking_id)
    ->leftJoin('event_management_lists', 'booking_details.event_management_id', '=', 'event_management_lists.id')
    ->select('booking_details.*', 'event_management_lists.*')
    ->first();
    // dd( $booking_details);


    return view('backend.booking_voucher.create' ,compact("booking_id", "guest","booking","others_price",'hall','booking_details'));
   }
}
