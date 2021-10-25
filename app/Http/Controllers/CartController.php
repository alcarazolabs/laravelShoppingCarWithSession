<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('cart');
    }

    public function add(int $id) {
        /* Define some defaults */
        $basePrice = 42.42;

        /* Add the product */
        \Cart::add($id, 'Product ' . $id, 1, $basePrice * $id, 500);

        /* Redirect to prevend re-adding on refreshing */
        return redirect()->route('cart')->withSuccess('Product has been successfully added to the Cart.');
    }

    public function addProduct(Request $request){
        //Paquete usado: https://packagist.org/packages/bumbummen99/shoppingcart
        //permite guardar productos en una sesión.
        $product = $request->product;
        //agregar producto al carrito:
     try{
       $product = [
            'id'=>uniqid(),
            'name' => $product,
            'price' => 33,
            'weight' => 100,
            'qty'=>2,
            'options' => ['unit'=>'kg']
       ];
       \Cart::add([$product]);
       // \Cart::add(['id' => 22, 'name' => 'Product 1', 'qty' => 1, 'price' => 9.99, 'options' => ['size' => 'large']]);

        
        return response()->json(
            [
                'product' => $product,
                'success' => true
            ]
            );
        }catch(\Exception $e){
            return response()->json(
                [
                    'error' => $e->getMessage(),
                    'success' => false
                ]
                );
        }
    
     }


     public function finishPurchase(){
        

     }
}
