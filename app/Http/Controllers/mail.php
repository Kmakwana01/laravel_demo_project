<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as FacadesMail;
use App\Mail\forgetPassword;

class mail extends Controller
{
    //
    public function sendMail()
    {
        $to = "kmakwana8232@gmail.com";
        $msg = "Checking";
        $sub = "Check";

        FacadesMail::to($to)->send(new ForgetPassword($msg, $sub));
    }
}
