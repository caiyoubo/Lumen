<?php
namespace App\Http\Controllers\Shoppingcart;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Syscover\ShoppingCart\CartProvider;

class ShoppingCartController extends BaseController
{
    public function set_add(Request $request)
    {
        $rt = CartProvider::instance()->add('293ad', 'Product 1', 1, 9.99, array('size' => 'large'));

        return $rt;
    }
}