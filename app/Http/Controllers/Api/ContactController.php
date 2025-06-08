<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::raw("Pesan dari: {$validated['name']} ({$validated['email']})\n\n{$validated['message']}", function ($mail) {
            $mail->to('elamore.tobelo@gmail.com')
                 ->subject('Pesan dari Form Kontak');
        });

        return response()->json(['message' => 'Pesan berhasil dikirim.']);
    }
}

