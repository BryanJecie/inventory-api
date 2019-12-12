<?php


namespace App\Api\V1\Controllers\Suppliers;


use App\Api\V1\Requests\Suppliers\StoreSupplierRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Suppliers\SupplierResource;
use App\Http\Resources\Suppliers\SuppliersResource;
use App\Repositories\General\SupplierRepository;

class SuppliersController extends Controller
{

   /**
    * @var SupplierRepository
    */
   private $supplierRepository;

   /**
    * SuppliersController constructor.
    * @param SupplierRepository $supplierRepository
    */
   public function __construct(SupplierRepository $supplierRepository)
   {

      $this->supplierRepository = $supplierRepository;
   }

   /**
    * @return SuppliersResource
    */
   public function index()
   {
//      abort_unless(true, 404,'Unauthorized');

      $suppliers = $this->supplierRepository->paginate();

      return new SuppliersResource($suppliers);

   }

   public function show($id)
   {
      abort_unless(true, 404,'Unauthorized');

      $supplier = $this->supplierRepository->findById($id);

      SupplierResource::withoutWrapping();

      return new SupplierResource($supplier);

   }


   /**
    * @param StoreSupplierRequest $request
    * @return SupplierResource
    */
   public function store(StoreSupplierRequest $request)
   {
      $formData = $request->only('name', 'abbr', 'email', 'phone', 'address');

      $supplier = $this->supplierRepository->create($formData);

      SupplierResource::withoutWrapping();

      return new SupplierResource($supplier);
   }

}