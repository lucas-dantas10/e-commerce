<?php 

namespace App\Services\User;

use App\Http\Resources\UserResource;
use App\Repository\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class UserService 
{
    public function __construct(
        protected UserRepository $userRepository
    )
    {}

    public function filterByUsers(): JsonResource
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = $this->userRepository->filterUsers($search, $sortField, $sortDirection, $perPage);
       
        return UserResource::collection($query);
    }
}
