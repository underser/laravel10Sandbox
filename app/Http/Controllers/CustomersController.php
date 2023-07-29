<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customers\Store;
use App\Http\Requests\Customers\Update;
use App\Models\User;
use App\Models\UserRoles;
use App\Services\CountryProvider;

class CustomersController extends Controller
{
    public function __construct(private CountryProvider $countryProvider)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->role(UserRoles::USER->value);
        $perPage = request()?->query('perPage');

        $users = ($perPage ? $users->paginate($perPage) : $users->paginate())->withQueryString();

        return view('crm.admin.customers.index', [
            'customers' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkUserAbility('manage users');
        return view('crm.admin.customers.create', [
            'countries' => $this->countryProvider->getCountries()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $this->checkUserAbility('manage users');

        return to_route('customers.show', User::factory()->create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('crm.admin.customers.show', [
            'customer' => $user,
            'countries' => $this->countryProvider->getCountries()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->checkUserAbility('manage users');

        return view('crm.admin.customers.edit', [
            'customer' => $user,
            'countries' => $this->countryProvider->getCountries()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, User $user)
    {
        $this->checkUserAbility('manage users');

        $user->update($request->validated());
        return to_route('customers.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->checkUserAbility('manage users');

        $user->delete();
        return to_route('customers.index');
    }
}
