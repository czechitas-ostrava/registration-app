<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Controllers\Auth;

use CzechitasApp\Http\Controllers\Controller;
use CzechitasApp\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Prologue\Alerts\Facades\Alert;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileController extends Controller
{
    public function profileForm(): View
    {
        return \view('auth.profile', [
            'name' => Auth::user()->name,
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        Auth::user()->update($request->getData());

        Alert::success(\trans('auth.profile.success'))->flash();

        return \back();
    }
}
