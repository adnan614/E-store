<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class FrontController extends Controller
{
    public function storeNewsLater(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|unique:newslaters|max:55',
        ]);

        $data = array();
        $data['email'] = $request->email;
        DB::table('newslaters')->insert($data);
        $notification = array(
            'messege' => 'Thanks for subscribing ',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
}
