<?php 

namespace App\Services\Customer;

use App\Http\Resources\CustomerListResource;
use App\Repository\CustomerRepository;

class CustomerService
{

    public function __construct(
        protected CustomerRepository $customerRepository
    )
    {}

    public function filterByCustomers()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $paginator = $this->customerRepository->filterCustomers(
            $search, $sortField, $sortDirection, $perPage
        );

        return CustomerListResource::collection($paginator);
    }
}
