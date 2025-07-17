<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Mail\ClientCatalogMail;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $client = $request->attributes->get('currentClient') ?? abort(404, 'Cliente no identificado');

        $client->load('siteSettings');

        Mail::to($request->email)->send(new ClientCatalogMail($client));

        return response()->json(['message' => 'Catálogo enviado']);
    }

    public function subscribeViaDomain(Request $request, $domain)
    {
        $client = Client::where('domain', $domain)->with('siteSettings')->firstOrFail();

        $request->validate(['email' => 'required|email']);

        Mail::to($request->email)->send(new ClientCatalogMail($client));

        return response()->json(['message' => 'Catálogo enviado vía fallback']);
    }
}
