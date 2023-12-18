<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description??"",
            'image' => $this->image??"",
            'status' => $this->status==1?true:false,
            'created_by' => $this->created_by??"",
            'updated_by' => $this->updated_by??"",
        ];
    }
}
