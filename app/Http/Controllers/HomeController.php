<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Talla_cantidad_compra;
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


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function costos()
    {
        $compras = array();     //El último registro en talla_cantidad_compras por producto
        $cantidades = array();  //Cantidad y defectuosos en última compra
        $cantCompra = array();  //Cantidad total por cada compra
        $productos = Producto::orderBy('nombre')->get();
        $ntallas = Compra::where('status', '=', 'Tienda')->get();

        foreach ($productos as $index => $producto) {
            $cantidades[$producto->id] = array();

            $talla = Talla_cantidad_compra::join('compras', 'talla_cantidad_compras.compra_id', '=', 'compras.id')
                ->where([
                    ['compras.status', '=', 'Tienda'],
                    ['talla_cantidad_compras.producto_id', '=', $producto->id]
                ])->latest('talla_cantidad_compras.created_at')->first();

            $cantidad = Talla_cantidad_compra::join('compras', 'talla_cantidad_compras.compra_id', '=', 'compras.id')
                ->where([
                    ['talla_cantidad_compras.compra_id', '=', $talla->compra_id],
                    ['talla_cantidad_compras.producto_id', '=', $producto->id]
                ])->select('talla_cantidad_compras.cantidad','talla_cantidad_compras.defectuosos')->get();

            array_push($compras, $talla);

            $cant = 0;
            $def = 0;

            foreach ($cantidad as $productoid => $valor) {
                $cant += $valor->cantidad;
                $def += $valor->defectuosos;
            }

            array_push($cantidades[$producto->id], ['cantidad' => $cant, 'defectuosos' => $def]);
        }

        foreach ($ntallas as $key => $talla) {
            $n = 0;
            $m = 0;
            foreach ($talla->compras as $value) {
                $n += $value->cantidad;
                $m += $value->defectuosos;
            }
            $cantCompra[$talla->id] = $m/$n;
        }

        return view('inventario.costos', ['compras' => $compras, 'productos' => $productos, 'cantidades' => $cantidades, 'cantCompra' => $cantCompra]);
    }
}
