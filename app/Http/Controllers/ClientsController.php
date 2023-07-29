<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRoles;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = User::query()->role(UserRoles::CLIENT->value);
        $perPage = request()?->query('perPage');

        $clients = ($perPage ? $clients->paginate($perPage) : $clients->paginate())->withQueryString();

        return view('crm.admin.clients.index', [
            'clients' => $clients
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('crm.admin.clients.show', [
            'client' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->checkUserAbility('manage clients');

        $user->delete();
        return to_route('clients.index');
    }
}
