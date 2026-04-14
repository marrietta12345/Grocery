<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Show the contact page
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Show the FAQ page
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'order_number' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

    
        return redirect()->route('contact')->with('success', 'Your message has been sent! We\'ll get back to you within 24 hours.');
    }
}