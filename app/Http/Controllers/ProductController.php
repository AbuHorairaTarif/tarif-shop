<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Product;
use Image;
use DB;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::where('publication_status',1)->get();
        $brands = Brand::where('publication_status',1)->get();
        
        return view('admin.product.add-product',[
            'categories'    => $categories,
            'brands'         => $brands
        ]);
    }
    
    protected function productInfoValidate($request)
    {
        $this->validate($request, [
         'product_name' => 'required'   
        ]);
    }
    
    protected function productImageUpload($request)
    {
        $productImage = $request->file('product_image');
        $imageName = date('YmdHis').'.'.$productImage->getClientOriginalExtension();
//        return $imageName;
        $directory = 'product-images/';
        $imageUrl = $directory.$imageName;
//        $productImage->move($directory,$imageName);
        Image::make($productImage)->save($imageUrl);
        return $imageUrl;
    }
    
    protected function saveProductBasicInfo($request, $imageUrl)
    {
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->product_quantity = $request->product_quantity;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->product_image = $imageUrl;
        $product->publication_status = $request->publication_status;
        $product->save();
    }

    public function saveProduct(Request $request){
        $this->productInfoValidate($request);
        $imageUrl = $this->productImageUpload($request);
        $this->saveProductBasicInfo($request, $imageUrl);
        
        return redirect('/product/add')->with('message', 'Product Info Saved Successfully');        
    }
    
    public function manageProduct()
    {
        $products = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->select('products.*', 'brands.brand_name', 'categories.category_name')
                ->get();
        return view('admin.product.manage-product',[
            'products'  => $products
        ]);
    }
    
    public function editProduct($id)
    {
        $productItem = Product::find($id);
         $categories = Category::where('publication_status',1)->get();
        $brands = Brand::where('publication_status',1)->get();
        return view('admin.product.edit-product', [
            'product'   => $productItem,
            'categories'    => $categories,
            'brands'         => $brands
        ]);
    }
    
    public function productBasicInfoUpdate($product, $request, $imageUrl = null)
    {
        $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
            $product->product_quantity = $request->product_quantity;
            $product->short_description = $product->short_description;
            $product->long_description = $request->long_description;
            if($imageUrl)
            {
            $product->product_image = $imageUrl;    
            }
            
            $product->publication_status = $request->publication_status;
            $product->save();
    }
    
    public function updateProduct(Request $request)
    {
        $productImage = $request->file('product_image');
        $product = Product::find($request->product_id);
        if($productImage)
        {
            if(file_exists($product->product_image))
            {
                unlink($product->product_image);
            }
            
            $imageUrl = $this->productImageUpload($request);
            $this->productBasicInfoUpdate($product, $request, $imageUrl);
                    
        }
        else {
            $this->productBasicInfoUpdate($product, $request);
        }
        return redirect('/product/manage')->with('message', 'Product Info Updated');
    }
    
}
