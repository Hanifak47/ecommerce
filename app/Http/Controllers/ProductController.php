<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductListResource;

// gunakan use di bawa untuk debugging
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // code di bawah ini adalah untuk debugging jika menggunakan server port berbeda dengan interface
        // Log::info('Data yang dikirimkan:', ['data' => 'jos']);

        // return response()->json([ // phpcs:ignore PEAR.Functions.FunctionCallSignature.ContentAfterOpenBracket
        //     'message' => 'Proses dihentikan untuk debugging.',
        //     'data_yang_dicek' => ProductListResource::collection(Product::query()->paginate(10))
        // ], 200); // phpcs:ignore PEAR.Functions.FunctionCallSignature.CloseBracketLine

        // Ambil nilai 'per_page' dari request, gunakan nilai default 10 jika tidak ada
        $perPage = request('per_page', 10);

        // Ambil nilai 'search' dari request
        $search = request('search', false);

        // Mulai query
        $query = Product::query();

        // Jika ada nilai 'search', tambahkan kondisi pencarian
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        return ProductListResource::collection($query->paginate($perPage));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //
        return new ProductResource(Product::create($request->validate()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        //
        $product->update($request->validate());
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return response()->noContent();
    }
}
