<?php


namespace App\Repositories\General;


use App\Models\Suppliers;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class SupplierRepository extends BaseRepository
{
   public function model()
   {
      return Suppliers::class;
   }

   public function findById($id)
   {
      return $this->model->find($id);
   }

   public function create(array $data) : Suppliers
   {
      return DB::transaction(function () use ($data) {
         $items = [];

         foreach ($data as $key => $value){
            $items[$key] = $value;
         }

         if ($supplier = parent::create($items)){
            return $supplier;
         };

      });
   }


}