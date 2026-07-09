<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\UserData;
use App\Enums\UserStatusEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(User::with('roles')->get());
    }

    public function show(User $user): JsonResponse
    {
        $user->load('roles');
        return response()->json($user);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $dto = new UserData(
            name: $validated['name'],
            username: $validated['username'],
            email: $validated['email'],
            phone: $validated['phone'] ?? null,
            status: isset($validated['status']) ? UserStatusEnum::from($validated['status']) : UserStatusEnum::Active,
            password: $validated['password'],
            roles: $validated['roles'] ?? null,
        );

        $user = $this->userService->createUser($dto);

        return response()->json($user->load('roles'), 201);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        $dto = new UserData(
            name: $validated['name'],
            username: $validated['username'],
            email: $validated['email'],
            phone: $validated['phone'] ?? null,
            status: isset($validated['status']) ? UserStatusEnum::from($validated['status']) : UserStatusEnum::Active,
            password: $validated['password'] ?? null, // Optionnel lors de l'update
            roles: $validated['roles'] ?? null,
        );

        $user = $this->userService->updateUser($user, $dto);

        return response()->json($user->load('roles'));
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $this->userService->deleteUser($user);
            return response()->json(null, 204);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
