<?php

namespace App\Http\Controllers\Swoole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        return response()->json(111, 200);
    }
}
