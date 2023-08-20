<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $context;
    public function __construct($resource, $context = null)
    {
        parent::__construct($resource);
        $this->context = $context;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->context === 'register') {
            return [
                'name' => $this->resource->name,
                'phone' => $this->resource->phone,
                'email' => $this->resource->email
            ];
        }
        elseif ($this->context === 'login') {
            return [
                'email' => $this->resource->email
            ];
        }
    }
}
