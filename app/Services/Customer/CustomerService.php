<?php

namespace App\Services\Customer;

use App\Enums\AddressType;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\CustomerAddress;
use App\Repository\CustomerRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function __construct(
        protected CustomerRepository $customerRepository
    ) {
    }

    public function filterByCustomers()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $paginator = $this->customerRepository->filterCustomers(
            $search, $sortField, $sortDirection, $perPage
        );

        return $paginator;
    }

    public function showCustomer(int $id)
    {
        $customer = $this->customerRepository
            ->find($id)
            ->with('user', 'shippingAddresses', 'billingAddresses')
            ->first();

        return $customer;
    }

    public function validateUpdateCustomer(CustomerRequest $request, int $id)
    {
        $customerData = $request->validated();
        $customerData['updated_by'] = $request->user()->id;
        $customerData['status'] = $customerData['status'] ? 1 : 0;
        $shippingData = $customerData['shippingAddress'];
        $billingData = $customerData['billingAddress'];
        $customer = $this->customerRepository->find($id);

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

            Log::critical(__METHOD__.' method does not work. '.$err->getMessage());
            throw $err;
        }

        DB::commit();

        return $customer;

        return new CustomerResource($customer);
    }
}
