<?php

namespace App\Http\Controllers\Admin\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Brand;
use DB;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function brand()
    {
        $brand = Brand::all();
        return view('admin.brand.brand', compact('brand'));
    }

    public function storeBrand(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required|unique:brands|max:55',
        ]);

        $data = array();
        $data['brand_name'] = $request->brand_name;
        $image = $request->file('brand_logo');
        if ($image) {
            // $image_name= str_random(5);
            $image_name = date('dmy_H_s_i');
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/media/brand/';
            $image_url = $upload_path . $image_full_name;
            $success = $image->move($upload_path, $image_full_name);

            $data['brand_logo'] = $image_url;
            $brand = DB::table('brands')
                ->insert($data);
            $notification = array(
                'messege' => 'Successfully Brand Inserted ',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        }
    }

    public function deleteBrand($id)
    {
        $data = DB::table('brands')->where('id', $id)->first();
        $image = $data->brand_logo;
        unlink($image);
        $brand = DB::table('brands')->where('id', $id)->delete();
        $notification = array(
            'messege' => 'Successfully Brand Deleted ',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }

    public function editBrand($id)
    {
        $brand = DB::table('brands')->where('id', $id)->first();
        return view('admin.brand.edit_brand', compact('brand'));
    }

    public function updateBrand(Request $request, $id)
    {
        $oldlogo = $request->old_logo;
        $data = array();
        $data['brand_name'] = $request->brand_name;
        $image = $request->file('brand_logo');
        if ($image) {
            unlink($oldlogo);
            $image_name = date('dmy_H_s_i');
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'public/media/brand/';
            $image_url = $upload_path . $image_full_name;
            $success = $image->move($upload_path, $image_full_name);
            $data['brand_logo'] = $image_url;
            $brand = DB::table('brands')->where('id', $id)->update($data);
            $notification = array(
                'messege' => 'Successfully Brand Updated ',
                'alert-type' => 'success'
            );
            return Redirect()->route('brands')->with($notification);
        } else {
            $brand = DB::table('brands')->where('id', $id)->update($data);
            $notification = array(
                'messege' => 'Update without image!',
                'alert-type' => 'success'
            );
            return Redirect()->route('brands')->with($notification);
        }
    }
}
