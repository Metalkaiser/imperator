<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Provider;
use App\Models\Carrier;
use App\Models\Producto;
use App\Models\Pago_compra;
use App\Models\Talla_cantidad_compra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::all();
        $proveedores = Provider::all();
        $carriers = Carrier::all();
        return view('compras.create', ['proveedores' => $proveedores, 'carriers' => $carriers, 'productos' => $productos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*  Reviso si es una empresa de envíos nueva    
        if ($request->casilleroselect == "nuevo") {
            $carrier = Carrier::create([
                'nombre' => $request->carriername,
                'casillero' => $request->casillero,
                'user_id' => 1,
                //'user_id' => Auth::id(),
            ]);
        /*  Si es una empresa de envíos existente    
        }else {
            $carrier = Carrier::find($request->casilleroselect);
        }
        /*  Reviso si es un proveedor de mercancías nuevo    
        if ($request->proveedorselect == "nuevo") {
            $proveedor = Provider::create([
                'nombre' => $request->proveedor,
                'url' => $request->url,
            ]);
            $proveedorid = $proveedor->id;
        /*  Si es un proveedor de mercancías existente    
        }else {
            $proveedorid = $request->proveedorselect;
        }
        /*  Reviso si es un producto nuevo    
        if ($request->mercancias == "nuevo") {
            $producto = Producto::create([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'provider_id' => $proveedorid,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
            ]);
            $productoid =  $producto->id;
        }else {
            $productoid =  $request->mercancias;
        }
        /*  Guardo la compra con sus datos por defecto, carrier y monto total    
        $compra = Compra::create([
            'carrier_id' => $carrier->id,
            'total' => $request->monto,
        ]);
        /*  Guardo los datos de pago de la compra    
        Pago_compra::create([
            'compra_id' => $compra->id,
            'tipo' => $request->pago,
            'referencia' => $request->referencia,
            'monto' => $request->monto,
            'moneda' => $request->moneda,
        ]);
        /*  Guardo la compra por talla y cantidad    
        Talla_cantidad_compra::create([
            'compra_id' => $compra->id,
            'producto_id' => $productoid,
            'talla' => $request->talla,
            'cantidad' => $request->cantidad,
            'precio' => $request->unidad,
            'provider_id' => $proveedorid,
        ]);
        return redirect()->route('inventario.index');       */

        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        //
    }
}
