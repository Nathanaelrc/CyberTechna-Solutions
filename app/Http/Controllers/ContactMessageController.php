<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'company' => ['nullable', 'string', 'max:160'],
            'service' => ['required', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:2500'],
        ]);

        ContactMessage::create($data);

        return redirect()->route('contact')
            ->with('status', 'Recibimos tu mensaje. CyberTechna Solutions te respondera pronto.');
    }
}