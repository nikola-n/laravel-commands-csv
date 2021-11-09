<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'name'     => $this->name,
            'email'    => $this->email,
            //you can fetch just the name of the roles relationship
            //but some user doesn't have name column
            //to avoid bug use the optional method
            'roles'    => optional($this->roles)->name,
            'allRoles' => $this->roles,
            'secret'   => $this->when(auth()->user()->isAdmin(), function () {
                return 'secret-value';
            }),
            //The mergeWhen method should not be used within arrays that mix string and numeric keys. Furthermore, it should not be used within arrays with numeric keys that are not ordered sequentially.
            $this->mergeWhen(Auth::user()->isAdmin(), [
                'first-secret'  => 'value',
                'second-secret' => 'value',
            ]),
        ];
    }

    public static $wrap = 'items';

    public $preserveKeys = true;

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
