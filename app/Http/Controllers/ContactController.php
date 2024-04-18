<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function contact(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $message = $request->message;

        try {
            Mail::to($email)->send(new ContactMail($name, 'william.correa.dev@gmail.com', $message));
            Log::info('E-mail enviado com sucesso para: ' . $email);
            return redirect()->back()->with('success', 'E-mail enviado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao enviar e-mail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao enviar o e-mail. Por favor, tente novamente mais tarde.');
        }
    }
}
