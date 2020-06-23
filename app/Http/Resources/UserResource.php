<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'  => $this->name,
            'email' => $this->email,
            //you can fetch just the name of the roles relationship
            //but some user doesn't have name column
            //to avoid bug use the optional method
            'roles' => optional($this->roles)->name,
        ];
    }

    //this method won't work if we paginate
    //we need to use UserCollection / --collection

    //if you want to wrap it and don't show that extra 'data' key
    //you need to remove this with method.
    public function with($request)
    {
        return ['status' => 'success'];
    }
}
////delegates to the eloquent toArray function
//return parent::toArray($request);
