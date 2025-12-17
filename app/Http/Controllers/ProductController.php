<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function index()
    {
        $products = Product::query()->orderBy('updated_at',  'desc')->paginate(5);

        // dd($products);
        return view('product.index', [ // phpcs:ignore PEAR.Functions.FunctionCallSignature.ContentAfterOpenBracket
            'products' => $products
        ]); // phpcs:ignore PEAR.Functions.FunctionCallSignature.CloseBracketLine
    }
}
