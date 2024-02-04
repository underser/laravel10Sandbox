<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customers\Store;
use App\Http\Requests\Api\V1\Customers\Update;
use App\Http\Resources\V1\CustomerResource;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CustomerResource::collection(User::role(UserRoles::USER->value)->paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new CustomerResource(User::role(UserRoles::USER->value)->findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!$user->hasRole(UserRoles::USER->value)) {
            $model = User::class;
            $id = $user->id;
            throw new NotFoundHttpException(__("No query results for model [{$model}] {$id}"), code: 404);
        }

        $user->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
