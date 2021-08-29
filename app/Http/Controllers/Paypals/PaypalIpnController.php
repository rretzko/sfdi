<?php

namespace App\Http\Controllers\Paypals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaypalIpnController extends Controller
{
    public function __invoke(Request $request) 
    {
        //$p = new \App\PaypalIpn;
        
        return route('webhook.paypal.ipn', []);
        //dd($request);
    }
    
/** END OF PUBLIC FUNCTIONS ***************************************************/
    
}
