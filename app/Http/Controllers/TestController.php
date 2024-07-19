<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function testmail()
    {
        Mail::to('rizsyad@gmail.com')->send(new InvoiceMail());
    }
}
