<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create()
    {
        $category = DB::table('categories')->get();
        $brand = DB::table('brands')->get();
        return view('admin.product.create', compact('category', 'brand'));
    }

    //subcategory collect by ajax request
    public function GetSubcat($category_id)
    {
        $cat = DB::table("subcategories")->where("category_id", $category_id)->get();
        return json_encode($cat);
    }

    public function store(Request $request)
    {
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['product_quantity'] = $request->product_quantity;
        $data['category_id'] = $request->category_id;
        $data['subcategory_id'] = $request->subcategory_id;
        $data['brand_id'] = $request->brand_id;
        $data['product_size'] = $request->product_size;
        $data['product_color'] = $request->product_color;
        $data['selling_price'] = $request->selling_price;
        $data['product_details'] = $request->product_details;
        $data['video_link'] = $request->video_link;
        $data['main_slider'] = $request->main_slider;
        $data['hot_deal'] = $request->hot_deal;
        $data['best_rated'] = $request->best_rated;
        $data['trend'] = $request->trend;
        $data['mid_slider'] = $request->mid_slider;
        $data['hot_new'] = $request->hot_new;
        $data['status'] = 1;

        $image_one = $request->image_one;
        $image_two = $request->image_two;
        $image_three = $request->image_three;

        if ($image_one && $image_two && $image_three) {
            $image_one_name = time() . rand(1, 100);
            $ext_one = strtolower($image_one->getClientOriginalExtension());
            $image_full_name_one = $image_one_name . '.' .  $ext_one;
            $upload_path_one = 'public/media/product/';
            $image_url_one = $upload_path_one . $image_full_name_one;
            $success_one = $image_one->move($upload_path_one, $image_full_name_one);
            $data['image_one'] = $image_url_one;

            $image_two_name = time() . rand(1, 100);
            $ext_two = strtolower($image_two->getClientOriginalExtension());
            $image_full_name_two = $image_two_name . '.' .  $ext_two;
            $upload_path_two = 'public/media/product/';
            $image_url_two = $upload_path_two . $image_full_name_two;
            $success_two = $image_two->move($upload_path_two, $image_full_name_two);
            $data['image_two'] = $image_url_two;

            $image_three_name = time() . rand(1, 100);
            $ext_three = strtolower($image_three->getClientOriginalExtension());
            $image_full_name_three = $image_three_name . '.' .  $ext_three;
            $upload_path_three = 'public/media/product/';
            $image_url_three = $upload_path_three . $image_full_name_three;
            $success_three = $image_three->move($upload_path_three, $image_full_name_three);
            $data['image_three'] = $image_url_three;

            $product = DB::table('products')
                ->insert($data);
            $notification = array(
                'messege' => 'Successfully Product Inserted ',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        }
    }
}
