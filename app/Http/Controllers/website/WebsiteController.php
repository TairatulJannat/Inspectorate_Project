<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
   public function login()
   {
      return view('frontend.pages.login');
   }
   public function register()
   {
      return view('frontend.pages.register');
   }


   public function home()
   {
      return view('frontend.pages.home');
   }
   public function about()
   {
      return view('frontend.pages.about');
   }
   public function contact()
   {
      return view('frontend.pages.contact_us');
   }
   public function photo_gallery()
   {
      return view('frontend.pages.photo_gallery');
   }
   public function video_gallery()
   {
      return view('frontend.pages.video_gallery');
   }
   public function event()
   {
      return view('frontend.pages.event');
   }
   public function senakunjo()
   {
      return view('frontend.pages.senakunjo_policies');
   }
   public function senamalancha()
   {
      return view('frontend.pages.senamalancha_policies');
   }
   public function milonayoton()
   {
      return view('frontend.pages.trust_milanaiton_policies');
   }
   public function senakunjo_calendar()
   {
      return view('frontend.pages.senakunjo_booking_calendar');
   }
   public function senamalancho_calendar()
   {
      return view('frontend.pages.senamalancho_booking_calendar');
   }
   public function milanaiton_calendar()
   {
      return view('frontend.pages.milanaiton_booking_calendar');
   }
   public function senakunjo_catering()
   {
      return view('frontend.pages.senakunjo_catering_list');
   }
   public function senamalancho_catering()
   {
      return view('frontend.pages.senamalancho_catering_list');
   }
   public function milanaiton_catering()
   {
      return view('frontend.pages.malancho_catering_list');
   }
}
