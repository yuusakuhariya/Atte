<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;

class MailTestController extends Controller
{
    public function sendTestEmail()
    {
        $details = [
            'title' => 'Test Email',
            'body' => 'This is a test email from Laravel with MailHog.',
        ];

        Mail::to('recipient@example.com')->send(new SampleMail($details));

        return "Test email sent successfully!";
    }
}
