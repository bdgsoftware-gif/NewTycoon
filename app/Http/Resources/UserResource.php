<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->when($request->user() && $request->user()->isAdmin(), $this->email),
            'phone' => $this->phone,
            'avatar' => $this->avatar ? asset('storage/' . $this->avatar) : null,
            'avatar_url' => $this->avatar ? asset('storage/' . $this->avatar) : null,
            'is_active' => $this->is_active,
            'email_verified_at' => $this->email_verified_at,
            'last_login_at' => $this->last_login_at,
            'role' => $this->role,
            'vendor_details' => $this->when($this->isVendor(), function () {
                return [
                    'store_name' => $this->store_name,
                    'store_slug' => $this->store_slug,
                    'store_description' => $this->store_description,
                    'store_logo' => $this->store_logo ? asset('storage/' . $this->store_logo) : null,
                    'store_banner' => $this->store_banner ? asset('storage/' . $this->store_banner) : null,
                    'store_rating' => $this->store_rating,
                    'store_review_count' => $this->store_review_count,
                    'store_status' => $this->store_status,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Include sensitive data only for the user themselves or admins
        if ($request->user() && ($request->user()->id === $this->id || $request->user()->isAdmin())) {
            $data['email'] = $this->email;
        }

        return $data;
    }

    /**
     * Customize the response for a given request.
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'version' => '1.0.0',
                'api_version' => 'v1',
            ],
        ];
    }
}
