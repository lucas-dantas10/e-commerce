<?php

namespace App\Services\User;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {
    }

    public function filterByUsers(): JsonResource
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = $this->userRepository->filterUsers($search, $sortField, $sortDirection, $perPage);

        return UserResource::collection($query);
    }

    public function createUser(array $data): JsonResource
    {
        $data['is_admin'] = true;
        $data['email_verified_at'] = date('Y-m-d H:i:s');
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        return new UserResource($user);
    }

    public function updateUser(array $data, $id): User
    {
        $user = $this->userRepository->find($id);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }
}
