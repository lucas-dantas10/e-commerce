<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use App\Models\CustomerAddress;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $countries = Country::where('code', 'usa')->first();
        $addressBilling = CustomerAddress::where('customer_id', $request->user()->id)
            ->where('type', AddressType::BillingAddresses->value)
            ->first();
        $addressShipping = CustomerAddress::where('customer_id', $request->user()->id)
            ->where('type', AddressType::ShippingAddresses->value)
            ->first();

        $states = json_decode($countries->states, true);

        $statesArray = [];

        foreach ($states as $key => $value) {
            $statesArray[] = [
                "siglas" => $key,
                "name" => $value
            ];
        }

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'country' => $countries,
            'states' => $statesArray,
            'addressBilling' => $addressBilling,
            'addressShipping' => $addressShipping,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Add a Shipping Address information for user.
     */
    public function storeShippingAddress(Request $request)
    {
        $requestValidated = $request->validate([
            'address1' =>  'string|max:255',
            'address2' =>  'string|max:255',
            'city' =>  'string|max:255',
            'zipcode' =>  'numeric|max:10',
            'country' =>  'string|max:50',
            'state' =>  'string|max:50',
            'sameShippingAddress' =>  'boolean',
        ]);
        
        auth()->user()->customer->shippingAddresses->update($requestValidated);
    }

    /**
     * Add a Billing Address information for user.
     */
    public function storeBillingAddress(Request $request)
    {
        $requestValidated = $request->validate([
            'addressOne' =>  'string|max:255',
            'addressTwo' =>  'string|max:255',
            'city' =>  'string|max:255',
            'cep' =>  'numeric',
            'country' =>  'string|max:50',
            'state' =>  'string|max:50',
            'sameShippingAddress' =>  'boolean',
        ]);

        auth()->user()->customer->billingAddresses->update($requestValidated);
    }
}
