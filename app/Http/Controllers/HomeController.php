<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Symfony\Component\VarDumper\Dumper\esc;

class HomeController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index()
    {
        return view('index');

    }
}
