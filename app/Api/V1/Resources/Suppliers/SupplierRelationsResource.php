<?php


namespace App\Api\V1\Resources\Suppliers;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

class SupplierRelationsResource extends Resource
{
   /**
    * @param Request $request
    * @return array
    */
   public function toArray($request)
   {
      return [];
   }
}