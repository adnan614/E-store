<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Model\Admin\Category;
use Illuminate\Http\Request;
use DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function category()
    {

        $category = Category::all();

        return view('admin.category.category', compact('category'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:55',

        ]);

        $data = array();

        $data['category_name'] = $request->category_name;
        DB::table('categories')->insert($data);
        $notification = array(
            'messege' => 'Category Done!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteCategory($id)
    {
        DB::table('categories')->where('id', $id)->delete();
        $notification = array(
            'messege' => 'Category successfully deleted!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function editCategory($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        return view('admin.category.edit_category', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|max:55',
        ]);
        $data = array();
        $data['category_name'] = $request->category_name;
        $update = DB::table('categories')->where('id', $id)->update($data);
        if ($update) {
            $notification = array(
                'messege' => 'Category Successfully Updated',
                'alert-type' => 'success'
            );
            return Redirect()->route('categories')->with($notification);
        } else {
            $notification = array(
                'messege' => 'Nothing to update',
                'alert-type' => 'success'
            );
            return Redirect()->route('categories')->with($notification);
        }
    }

    public function subcategories()
    {
        $category = DB::table('categories')->get();
        $subcat = DB::table('subcategories')
            ->join('categories', 'subcategories.category_id', 'categories.id')
            ->select('subcategories.*', 'categories.category_name')
            ->get();
        return view('admin.category.subcategory', compact('category', 'subcat'));
    }

    public function storesubcat(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required|',
        ]);

        $data = array();
        $data['category_id'] = $request->category_id;
        $data['subcategory_name'] = $request->subcategory_name;
        DB::table('subcategories')->insert($data);
        $notification = array(
            'messege' => 'Sub Category Inserted',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }

    public function deleteSub($id)
    {
        DB::table('subcategories')->where('id', $id)->delete();
        $notification = array(
            'messege' => 'Sub Category Deleted',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
}
