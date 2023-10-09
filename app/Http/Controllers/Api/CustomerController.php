<?php

namespace App\Http\Controllers\Api;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CustomerListResource;
use App\Http\Resources\CustomerResource;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Services\Customer\CustomerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{

    public function __construct(
        protected CustomerService $customerService
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->customerService->filterByCustomers();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $customer = Customer::findOrFail($id)->with('user', 'shippingAddresses', 'billingAddresses')->first();

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, int $id)
    {
        $customerData = $request->validated();
        $customerData['updated_by'] = $request->user()->id;
        $customerData['status'] = $customerData['status'] ? 1 : 0;
        $shippingData = $customerData['shippingAddress'];
        $billingData = $customerData['billingAddress'];
        $customer = Customer::findOrFail($id);

        DB::beginTransaction();

        try {
            $customer->update($customerData);

            if ($customer->shippingAddresses) {
                $customer->shippingAddresses->update($shippingData);
            } else {
                $shippingData['customer_id'] = $customer->user_id;
                $shippingData['type'] = AddressType::ShippingAddresses->value;
                CustomerAddress::create($shippingData);
            }
    
            if ($customer->billingAddresses) {
                $customer->billingAddresses->update($billingData);
            } else {
                $billingData['customer_id'] = $customer->user_id;
                $billingData['type'] = AddressType::BillingAddresses->value;
                CustomerAddress::create($billingData);
            }
        } catch (Exception $err) {
            DB::rollBack();

            Log::critical(__METHOD__ . ' method does not work. '. $err->getMessage());
            throw $err;
        }

        DB::commit();

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return response()->noContent();
    }

    public function countries() {
        $query = Country::query()->orderBy('name', 'asc')->get();

        return CountryResource::collection($query);
    }
}
