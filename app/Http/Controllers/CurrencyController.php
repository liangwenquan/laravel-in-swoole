<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        $query = [
            'match' => [
                'name' => 'Waves',
            ]
        ];

        $filed = [
            'name',
            'symbol',
        ];
        $currencies = Currency::searchByQuery( $query,null, $filed, 1, 2)->toArray();

        return response()->json($currencies, 200);
    }
}
