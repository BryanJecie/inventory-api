<?php


namespace App\Models\Auth\Traits\Methods;


trait UserMethod
{
   /**
    * @return bool
    */
   public function isAdmin()
   {
      return $this->name == 'admin' ? true : false;
   }

   /**
    * @return mixed
    */
   public function isPending()
   {
      return !$this->confirmed;
   }

   /**
    * @return mixed
    */
   public function isConfirmed()
   {
      return $this->confirmed;
   }

}