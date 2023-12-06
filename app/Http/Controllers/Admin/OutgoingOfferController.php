<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OutgoingOfferController extends Controller
{
    //
    public function outgoing()
    {
        return view('backend.offer.offer_outgoing.outgoing');
    }
}