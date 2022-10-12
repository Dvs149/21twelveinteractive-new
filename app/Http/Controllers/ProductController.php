<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
      
      return view('admin.products.index',compact('products'))
          ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'price' => 'required',
            // 'image' => 'required',
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->detail = $request->detail;
        $product->status = "1";
        $product->price = $request->price;
        $product->created_by = Auth::user()->id;

        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move(config('custom.PRODUCT_IMAGE_PATH'), $fileName);
            $product->image=$fileName;
        }else {
            $product->image=0;
        }
        $product->save();
       
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }
/**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
     public function show(Product $product)
    {
        // dd($product->toArray());
        return view('admin.products.show',compact('product'));
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit',compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'price' => 'required',
        ]);
      
        $product = Product::find($product->id);
        if(!$product){
            return $this->errorJson('Product Not found.', [
                'update' => "fail",
            ]);
        }else {
            $product->name = $request->name;
            $product->detail = $request->detail;
            $product->status = $request->status;
            $product->price = $request->price;
            $product->created_by = Auth::user()->id;
            // dd($product);
            
            if (request()->hasFile('image')) {
                
                if(!empty($product->image)){
                    //check wether image is stored or not, if stored then removed old image
                    $file= $product->image;
                    @unlink(config('custom.PRODUCT_IMAGE_PATH').$file);
                }
                $file = request()->file('image');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move(config('custom.PRODUCT_IMAGE_PATH'), $fileName);
                $product->image=$fileName;
            }
            $product->save();

            return redirect()->route('products.index')
                            ->with('success','Product updated successfully');
        }
        
      
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product->id);
        // dd($product->toArray());
        if(!$product){
            return $this->errorJson('Product Not found.', [
                'deleted' => "fail",
            ]);
        }else {
            if(!empty($product->image)){
                    //check wether image is stored or not, if stored then removed old image
                    $file= $product->image;
                    @unlink(config('custom.PRODUCT_IMAGE_PATH').$file);
                }
            $product->delete();
        }
       
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}