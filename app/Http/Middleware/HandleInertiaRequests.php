<?php

namespace App\Http\Middleware;

use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $unresolvedAlertsCount = 0;

        if (Auth::check()) {
            $unresolvedAlertsCount = Auth::user()->storageTanks()
                ->with(['customAlerts.alerts' => function($query) {
                    $query->where('status', 'unresolved');
                }])
                ->get()
                ->pluck('customAlerts')
                ->flatten()
                ->pluck('alerts')    
                ->flatten()
                ->count();
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'unresolved_alerts' => [
                'count' => $unresolvedAlertsCount
            ],
        ];
    }
}
