<?php

namespace App\Http\Controllers;

use App\Mail\SampleEmail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationNotificationEmail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'application_status'=>'required',
            'remarks'=>'required',
            'inspection_date'=>'required',
        ]);

        $recipient = $validatedData['email']; // Change to the recipient's email address
        // $recipient = 'blabla@gmail.com';
        $data = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'application_status' => $validatedData['application_status'],
            'remarks' => $validatedData['remarks'],
            'inspection_date'=>$validatedData['inspection_date'],
        ]; // Data to pass to the email view

        $emailSent = Mail::to($recipient)->send(new ApplicationNotificationEmail($data['name'], $data['email'], $data['application_status'], $data['remarks'], $data['inspection_date']));

        if ($emailSent instanceof \Illuminate\Mail\SentMessage) {
            return response()->json(['message' => 'Email sent successfully to ' . $recipient]);
        } else {
            return response()->json(['message' => 'Email was not sent successfully to ' . $recipient]);
        }


    }
}
