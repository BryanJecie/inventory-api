<?php


namespace App\Api\V1\Requests\Suppliers;


use Dingo\Api\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
   /**
    * @return bool
    */
   public function authorize()
   {
      return true;
   }

   /**
    * @return array
    */
   public function rules()
   {
      return [
         'name' => 'required|min:3|unique:suppliers',
      ];
   }
}