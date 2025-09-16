<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    // wrap by default true namun untuk agar bisa menampilkan data di modal maka falsekanF
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image,
            'price' => $this->price,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'), // phpcs:ignore Zend.NamingConventions.ValidVariableName.NotCamelCaps
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'), // phpcs:ignore Zend.NamingConventions.ValidVariableName.NotCamelCaps
        ];
    }
}
