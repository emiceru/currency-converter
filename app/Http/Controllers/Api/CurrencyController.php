<?php

namespace App\Http\Controllers\Api;

use App\Actions\ConvertCurrencyAction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function convert(Request $request)
    {
        try {
            $result = ConvertCurrencyAction::run($request->all());
            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
