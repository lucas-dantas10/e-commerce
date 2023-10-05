<?php 

namespace App\Repository;

use App\Models\User;

class UserRepository extends AbstractRepository
{
    protected static $model = User::class;

    public function filterUsers(
        string $search, 
        string $sortField, 
        string $sortDirection, 
        int $perPage
    )
    {
        $users = self::loadModel()::query()
            ->where('name', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return $users;
    }
}
