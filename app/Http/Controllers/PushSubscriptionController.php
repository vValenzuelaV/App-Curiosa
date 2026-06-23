<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    /**
     * Guarda o actualiza la suscripci\u00f3n push del dispositivo actual.
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint'   => 'required|string|max:500',
            'public_key' => 'nullable|string',
            'auth_token' => 'nullable|string',
        ]);

        PushSubscription::updateOrCreate(
            ['endpoint' => $request->endpoint],
            [
                'public_key' => $request->public_key,
                'auth_token' => $request->auth_token,
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * Elimina la suscripci\u00f3n del dispositivo (al denegar permisos).
     */
    public function unsubscribe(Request $request)
    {
        $request->validate(['endpoint' => 'required|string']);

        PushSubscription::where('endpoint', $request->endpoint)->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Devuelve la clave p\u00fablica VAPID al frontend.
     */
    public function vapidPublicKey()
    {
        return response()->json(['key' => env('VAPID_PUBLIC_KEY')]);
    }
}
