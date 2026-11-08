<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\ProductPhoto;
use App\Models\Review;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id','asc')->get();
        return view('admin.product.index',compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:products,slug',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'stock' => 'required|integer',
        ]);

        $obj = new Product();
        if($request->hasFile('image')) {
            $final_name = 'product_image_'.time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->image = $final_name;
        }
        $obj->name = $request->name;
        $obj->slug = $request->slug;
        $obj->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $obj->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;
        $obj->price = $request->price;
        $obj->old_price = $request->old_price;
        $obj->stock = $request->stock;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:products,slug,'.$id,
            'short_description' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'stock' => 'required|integer',
        ]);

        $obj = Product::where('id', $id)->first();
        if($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'product_image_'.time().'.'.$request->image->extension();
            if($obj->image && file_exists(public_path('uploads/'.$obj->image))) {
                unlink(public_path('uploads/'.$obj->image));
            }
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->image = $final_name;
        }
        $obj->name = $request->name;
        $obj->slug = $request->slug;
        $obj->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $obj->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;
        $obj->price = $request->price;
        $obj->old_price = $request->old_price;
        $obj->stock = $request->stock;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function delete($id)
    {

        ProductSpecification::where('product_id', $id)->delete();

        $all_photos = ProductPhoto::where('product_id', $id)->get();
        foreach($all_photos as $photo) {
            if($photo->photo && file_exists(public_path('uploads/'.$photo->photo))) {
                unlink(public_path('uploads/'.$photo->photo));
            }
        }
        ProductPhoto::where('product_id', $id)->delete();

        $obj = Product::where('id', $id)->first();
        if($obj->image && file_exists(public_path('uploads/'.$obj->image))) {
            unlink(public_path('uploads/'.$obj->image));
        }
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    public function specifications($product_id)
    {
        $product = Product::where('id', $product_id)->first();
        $product_specifications = ProductSpecification::where('product_id', $product_id)->get();
        return view('admin.product.specification', compact('product_specifications', 'product'));
    }

    public function specification_store(Request $request, $product_id)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|string',
        ]);

        $obj = new ProductSpecification();
        $obj->product_id = $product_id;
        $obj->name = $request->name;
        $obj->value = $request->value;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function specification_update(Request $request, $specification_id)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|string',
        ]);

        $obj = ProductSpecification::where('id', $specification_id)->first();
        $obj->name = $request->name;
        $obj->value = $request->value;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function specification_delete(Request $request, $specification_id)
    {
        $obj = ProductSpecification::where('id', $specification_id)->first();
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }


    public function photos($product_id)
    {
        $product = Product::where('id', $product_id)->first();
        $product_photos = ProductPhoto::where('product_id', $product_id)->get();
        return view('admin.product.photo', compact('product_photos', 'product'));
    }

    public function photo_store(Request $request, $product_id)
    {
        $request->validate([
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $obj = new ProductPhoto();

        if($request->hasFile('photo')) {
            $final_name = 'product_photo_'.time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->photo = $final_name;
        }

        $obj->product_id = $product_id;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function photo_update(Request $request, $photo_id)
    {
        $obj = ProductPhoto::where('id', $photo_id)->first();

        if($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'product_photo_'.time().'.'.$request->photo->extension();
            if($obj->photo && file_exists(public_path('uploads/'.$obj->photo))) {
                unlink(public_path('uploads/'.$obj->photo));
            }
            $request->photo->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->photo = $final_name;
        }

        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function photo_delete(Request $request, $photo_id)
    {
        $obj = ProductPhoto::where('id', $photo_id)->first();
        if($obj->photo && file_exists(public_path('uploads/'.$obj->photo))) {
            unlink(public_path('uploads/'.$obj->photo));
        }
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    public function reviews()
    {
        $reviews = Review::get();
        return view('admin.product.review', compact('reviews'));
    }

    public function review_delete($id)
    {
        $obj = Review::where('id', $id)->first();
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
