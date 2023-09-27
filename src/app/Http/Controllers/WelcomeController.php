<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class WelcomeController extends Controller
{
    public function index(): JsonResponse
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
