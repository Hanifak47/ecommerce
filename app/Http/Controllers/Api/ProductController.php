<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

// gunakan use di bawa untuk debugging
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductListResource;

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


        $sortField = request('sort_field', 'updated_at');

        $sortDirection = request('sort_direction', 'desc');

        // Mulai query
        $query = Product::query();

        $query->orderBy($sortField, $sortDirection);

        // Jika ada nilai 'search', tambahkan kondisi pencarian
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // dengan paginate ini otomatis mengembalikan nilai meta dsb
        return ProductListResource::collection($query->paginate($perPage));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile $image */
        // niali dari gambar adalah image sedangakan jik tidak ada maka bernilai null
        $image = $data['image'] ?? null;
        // jika data yg disimpan ada gambaranya
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();
        }

        $product = Product::create($data);

        //
        return new ProductResource($product);
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
     * Update the specified resource in storage
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile $image */

        // set gambar ada atau tidak berdasarkan requestnya
        $image = $data['image'] ?? null;
        // Check if image was given and save on local file system
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();

            // If there is an old image, delete it
            if ($product->image) {
                Storage::deleteDirectory('/public/' . dirname($product->image));
            }
        }

        $product->update($data);

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

    // private function saveImage(\Illuminate\Http\UploadedFile $image)
    // {
    //     $path = 'images/' . Str::random();

    //     if (!Storage::exists($path)) {
    //         Storage::makeDirectory($path, 0755, true);
    //     }

    //     if (!Storage::putFileAs('public/' . $path, $image, $image->getClientOriginalName())) {
    //         throw new \Exception(message: "Unable to save file \"{$image->getClientOriginalName()}\"");
    //     }

    //     return $path . '/' . $image->getClientOriginalName();
    // }

    private function saveImage(\Illuminate\Http\UploadedFile $image)
    {
        // Cukup gunakan putFileAs untuk menyimpan file.
        // Metode ini akan otomatis membuat direktori jika belum ada.
        $path = 'public/images';
        $name = Str::random(40) . '.' . $image->getClientOriginalExtension();

        // Simpan file dengan nama unik ke dalam direktori 'public/images'
        $imagePath = $image->storeAs($path, $name);

        // Kembalikan path relatif dari 'storage/app'
        return str_replace('public/', '', $imagePath);
    }
}
