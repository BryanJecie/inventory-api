<?php


namespace App\Http\Resources\Suppliers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SuppliersResource extends ResourceCollection
{
   /**
    * @param Request $request
    * @return array
    */
   public function toArray($request)
   {
      return [
         'data' => SupplierResource::collection($this->collection)
      ];
   }

   /**
    * @param Request $request
    * @return array
    */
   public function with($request)
   {
      return [
         'author' => [
            'name' => Config('access.author.name'),
            'website' => Config('access.author.website')
         ]
      ];
   }
}