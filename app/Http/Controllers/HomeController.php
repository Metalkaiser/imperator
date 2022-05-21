<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Venta;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ventas = Venta::where('created_at', '>=', date('Y-m-d', strtotime("-1 month")))->orderBy('created_at', 'desc')->get();
        $compras = Compra::where('created_at', '>=', date('Y-m-d', strtotime("-1 month")))->orderBy('created_at', 'desc')->get();

        return view('home',[
            'ventas' => $ventas,
            'compras' => $compras,
        ]);
    }
}
