<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Email;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    public function index()
    {
        return Email::latest()->get();
    }

    public function show($id)
    {
        $email = Email::findOrFail($id);
        $email->update(['read' => true]);
        //return $email;
        return response()->json($email);

    }

    public function send()
    {
        $emails = Email::all();

        foreach ($emails as $email) {
            dispatch(new SendEmailJob($email));
        }

        return "Emails queued!";
    }
    
    public function store(Request $request)
    {
        
        $data = $request->validate([
        'sender' => 'required|email',
        'recipient' => 'required|email',
        'subject' => 'required|string',
        'body' => 'nullable|string',
        'attachments' => 'nullable|array',
    ]);

        $email = Email::create([
        'sender' => $data['sender'],
        'recipient' => $data['recipient'],
        'subject' => $data['subject'],
        'body' => $data['body'] ?? null,
        'attachments' => $data['attachments'] ?? [],
        'read' => false,
    ]);

    // Simulated email send / save
    return response()->json([
        'message' => 'Email logged (simulated)',
        'payload' => $data
    ], 201);
    }
}

