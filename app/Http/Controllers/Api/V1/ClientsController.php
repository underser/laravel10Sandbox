<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ClientResource;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ClientResource::collection(User::role(UserRoles::CLIENT->value)->with(['projects.status'])->paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ClientResource(User::role(UserRoles::CLIENT->value)->with('projects.status')->findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!$user->hasRole(UserRoles::CLIENT->value)) {
            $model = User::class;
            $id = $user->id;
            throw new NotFoundHttpException(__("No query results for model [{$model}] {$id}"), code: Response::HTTP_NOT_FOUND);
        }

        $user->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
