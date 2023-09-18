<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return response()->json(
            responseData(
                true,
                200,
                'Ad group IP management is live',
                []
            )
        );
    }
}
