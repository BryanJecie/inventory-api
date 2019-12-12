<?php


namespace App\Api\V1\Resources\Suppliers;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

class SupplierResource extends Resource
{
   /**
    * @param Request $request
    * @return array
    */
   public function toArray($request)
   {
      return [
         'attributes' => [
            'id' => $this->id,
            'abbr' => $this->abbr,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'created' => $this->created_at,
            'last_updated' => $this->updated_at
         ],
         'relations' => new SupplierRelationsResource($this),
         'links' => [
            'self' => ''
         ]
      ];
   }

   /**
    * @param $request
    * @return array
    */
   public function with($request)
   {
      return [
         'type' => 'Supplier',
         'vars' => [
            'loading' => false
         ],
      ];
   }
}

