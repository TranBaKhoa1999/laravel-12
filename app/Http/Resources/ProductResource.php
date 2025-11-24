<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'sku' => $this->sku,
            'image' => $this->image,
            'image_url' => $this->image_url,
            'category_id' => $this->category_id,
            'category' => $this->category, // Nếu bạn muốn bao gồm dữ liệu của category
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
