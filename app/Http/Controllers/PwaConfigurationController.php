<?php

namespace App\Http\Controllers;

use App\Http\Requests\PwaConfigurationStoreRequest;
use App\Models\Option;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PwaConfigurationController extends Controller
{
    /**
     * Show the pwa configuration
     * @method GET /admin/pwa-configuration
     * @return Renderable|RedirectResponse
     */

    public function show(): Renderable | RedirectResponse
    {
        try {
            $active = 'pwaconfig';
            return view('admin.configuration.pwa-configuration', compact('active'));
        } catch (Exception $e) {
            return redirect()->back()->with('msg', $e->getMessage());
        }
    }

    /**
     * Show the pwa configuration
     * @method GET /admin/pwa-configuration
     * @param Request $request
     * @return Renderable|RedirectResponse
     */

    public function store(PwaConfigurationStoreRequest $request): Renderable | RedirectResponse
    {
        try {
            if ($request->hasFile('pwa_app_72_72_icon')) {
                @unlink(public_path(Option::get_option('pwa_app_72_72_icon')));
                $icon72 = $request->pwa_app_72_72_icon->storeAs('icons', 'identitius-72x72.png', 'public');
                Option::update_option('pwa_app_72_72_icon', '/storage/' . $icon72);
            }
            if ($request->hasFile('pwa_app_96_96_icon')) {
                @unlink(public_path(Option::get_option('pwa_app_96_96_icon')));
                $icon96 = $request->pwa_app_96_96_icon->storeAs('icons', 'identitius-96x96.png', 'public');
                Option::update_option('pwa_app_96_96_icon', '/storage/' . $icon96);
            }
            if ($request->hasFile('pwa_app_128_128_icon')) {
                @unlink(public_path(Option::get_option('pwa_app_128_128_icon')));
                $icon128 = $request->pwa_app_128_128_icon->storeAs('icons', 'identitius-128x128.png', 'public');
                Option::update_option('pwa_app_128_128_icon', '/storage/' . $icon128);
            }
            return redirect()->back()->with('msg', 'PWA Configuration Saved Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', $e->getMessage());
        }
    }
}
