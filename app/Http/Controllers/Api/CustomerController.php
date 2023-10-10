<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CustomerListResource;
use App\Http\Resources\CustomerResource;
use App\Models\Country;
use App\Models\Customer;
use App\Services\Customer\CustomerService;
use Illuminate\Http\Request;

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
        $paginatorOfCustomers = $this->customerService->filterByCustomers();

        return CustomerListResource::collection($paginatorOfCustomers);
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
        $customer = $this->customerService->showCustomer($id);

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, int $id)
    {
        $customerValidated = $this->customerService
            ->validateUpdateCustomer($request, $id);

        return new CustomerResource($customerValidated);
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
