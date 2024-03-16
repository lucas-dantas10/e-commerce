<?php

namespace App\Repository;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerRepository extends AbstractRepository
{
    protected static $model = Customer::class;

    public function filterCustomers(
        string $search,
        string $sortField,
        string $sortDirection,
        int $perPage
    ) {

        $query = self::loadModel()::query()
            ->with('user')
            ->orderBy("customers.{$sortField}", $sortDirection);

        if ($search) {
            $query
                ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                ->join('users', 'customers.user_id', '=', 'users.id')
                ->orWhere('users.email', 'like', "%{$search}%")
                ->orWhere('customers.phone', 'like', "%{$search}%");
        }

        $paginator = $query->paginate($perPage);

        return $paginator;
    }
}
