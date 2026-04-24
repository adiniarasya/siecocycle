<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
        return response()->json(
            Bank::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get()
        );
    }
}