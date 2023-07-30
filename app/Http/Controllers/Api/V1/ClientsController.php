<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Projects\Store;
use App\Http\Resources\V1\ClientResource;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    public function destroy(string $id)
    {
        User::role(UserRoles::CLIENT->value)->findOrFail($id)->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
