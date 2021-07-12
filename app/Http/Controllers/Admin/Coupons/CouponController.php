<?php

namespace App\Http\Controllers\Admin\Coupons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function coupon()
    {
        $coupon = DB::table('coupons')->get();
        return view('admin.coupon.coupon', compact('coupon'));
    }

    public function StoreCoupon(Request $request)
    {
        $data = array();

        $data['coupon'] = $request->coupon;
        $data['discount'] = $request->discount;
        DB::table('coupons')->insert($data);
        $notification = array(
            'messege' => 'Coupon Insert Done!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteCoupon($id)
    {
        DB::table('coupons')->where('id', $id)->delete();
        $notification = array(
            'messege' => 'Coupon successfully deleted!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function editCoupon($id)
    {
        $coupon = DB::table('coupons')->where('id', $id)->first();
        return view('admin.coupon.edit_coupon', compact('coupon'));
    }

    public function updateCoupon(Request $request, $id)
    {
        $data = array();
        $data['coupon'] = $request->coupon;
        $data['discount'] = $request->discount;
        DB::table('coupons')->where('id', $id)->update($data);
        $notification = array(
            'messege' => 'Coupon Update Done',
            'alert-type' => 'success'
        );
        return Redirect()->route('admin.coupon')->with($notification);
    }

    public function newslater()
    {
        $sub = DB::table('newslaters')->get();
        return view('admin.newlater.newslater', compact('sub'));
    }

    public function deleteNewslater($id)
    {
        DB::table('newslaters')->where('id', $id)->delete();
        $notification = array(
            'messege' => 'Subscriber Delete Done',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
}
