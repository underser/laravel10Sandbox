<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\Store;
use App\Http\Requests\Clients\Update;
use App\Models\Client;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::query();
        $perPage = request()?->query('perPage');

        $clients = ($perPage ? $clients->paginate($perPage) : $clients->paginate())->withQueryString();

        return view('crm.admin.clients.index', [
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crm.admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        return to_route('clients.show', Client::factory()->create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('crm.admin.clients.show', [
            'client' => $client,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('crm.admin.clients.edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Client $client)
    {
        $client->update($request->validated());
        return to_route('clients.show', $client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return to_route('clients.index');
    }
}
