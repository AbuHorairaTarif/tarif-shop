<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Brand;
use DB;

class NewShopController extends Controller
{
    public function index() {
        $newProducts = Product::where('publication_status', 1)
                               ->orderBy('id', 'DESC')
                               ->take(6)
                               ->get();
         
        return view('front-end.home.home', [
            'newProducts'    => $newProducts
        ]);
    }
    
    public function categoryProduct($id) {
        $categoryProducts = Product::where('category_id', $id)
                ->where('publication_status',1)
                ->get();
        return view('front-end.category.category-content',[
            'categoryProducts' => $categoryProducts
        ]);
    }
    
    public function productDetails($id)
    {
        $product = Product::find($id);
        $newProducts = Product::where('publication_status', 1)
                               ->orderBy('id', 'ASC')
                               ->take(8)
                               ->get();
        return view('front-end.product.product-details', [
            'product'               => $product,
            'newProducts'       => $newProducts
        ]);
    }
    
    public function brandProduct($id)
    {
        $brandName = Brand::find($id);
        $brandProducts = DB::table('products')
                            ->join('brands', 'products.brand_id', '=', 'brands.id')
                            ->where('brands.id',$id)
                            ->select('products.*', 'brands.brand_name')                   
                            ->get();
        
        return view('front-end.product.brand-product', [
            'brandProducts'      => $brandProducts,
            'brandName'           => $brandName
        ]);
    }
    
    public function contactAddress(){
        return view('front-end.contact.contact-address');
    }
    
    public function productItem(){
        return view('front-end.product.product-item');
    }
    
    public function registerUser() {
        return view('front-end.registration.createaccount');
    }
    
    public function loginUser(){
        return view('front-end.registration.loginAccount');
    }
    
    public function houseHold(){
        return view('front-end.category.house-hold');
    }
    
    public function personalCare() {
        return view('front-end.category.personal-care');
    }
    
    public function packedfood()
    {
        return view('front-end.category.packed-food');        
    }
    
    public function beverage() {
        return view('front-end.category.beverage');
    }
    
    public function gourmet(){
        return view('front-end.category.gourmet');
    }
    
    public function offer()
    {
        return view('front-end.offers.offer');
    }
    
    public function aboutUs()
    {
        return view('front-end.contact.about-us');
    }
    
    public function shortCode() {
        return view('front-end.offers.short-code');    
    }
    
    public function faq()
    {
        return view('front-end.contact.faq');
    }
    
    public function checkOut()
    {
        return view('front-end.contact.checkout');
    }
    
    
    
    
}