<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\ApiLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login(ApiLoginRequest $request): \Illuminate\Http\JsonResponse
    {

        $request->validated();

        if (! Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('Invalid Credentials', 500);
        }

        $user = User::firstWhere('email', $request->get('email'));

        return $this->ok(
            'Authenticated',
            new UserResource($user),
        );
    }
}
