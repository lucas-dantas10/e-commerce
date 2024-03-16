<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
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
        $customer = $request->user()->customer;
        $addressBilling = $customer->billingAddresses;
        $addressShipping = $customer->shippingAddresses;
        $countryBilling = $addressBilling->country;
        $countryShipping = $addressShipping->country;
        $countries = Country::all();

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'countries' => $countries,
            'addressBilling' => $addressBilling,
            'addressShipping' => $addressShipping,
            'countryBilling' => $countryBilling,
            'countryShipping' => $countryShipping,
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
            'address1' => 'string|max:255',
            'address2' => 'string|max:255',
            'city' => 'string|max:255',
            'zipcode' => 'numeric|max:10',
            'country_code' => 'string|max:3',
            'state' => 'string|max:50',
            'sameShippingAddress' => 'boolean',
        ]);

        auth()->user()->customer->shippingAddresses->update($requestValidated);
    }

    /**
     * Add a Billing Address information for user.
     */
    public function storeBillingAddress(Request $request)
    {
        $requestValidated = $request->validate([
            'address1' => 'string|max:255',
            'address2' => 'string|max:255',
            'city' => 'string|max:255',
            'zipcode' => 'numeric|max:10',
            'country_code' => 'string|max:3',
            'state' => 'string|max:50',
            'sameShippingAddress' => 'boolean',
        ]);

        auth()->user()->customer->billingAddresses->update($requestValidated);
    }
}
