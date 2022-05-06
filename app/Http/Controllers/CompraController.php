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
use Illuminate\Support\Facades\Storage;

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
        $productos = Producto::orderBy('nombre')->get();
        $proveedores = Provider::orderBy('nombre')->get();
        $carriers = Carrier::orderBy('casillero')->get();
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
        $prod_arr = array();
        //Datos generales de la compra
        if ($request->casilleroselect == "nuevo") {     //si el casillero es nuevo
            $casillero = new Carrier;
            $casillero->nombre = $request->carriername;
            $casillero->casillero = $request->casillero;
            if ($casillero->save()) {
                $carrier = $casillero->id;
            }else {
                return redirect()->back()->with('error', 'Ocurrió un error al guardar el casillero.');
            }
        }else {     //si es un casillero existente
            $carrier = $request->casilleroselect;
        }
        //Se guardan los datos principales de la compra
        $compra = new Compra;
        $compra->carrier_id = $carrier;
        $compra->total = $request->monto;
        //Se guardan los datos de pago de la compra;
        $pago = new Pago_compra;
        $pago->tipo =  $request->pago;
        $pago->referencia =  $request->referencia;
        $pago->monto =  $request->monto;
        $pago->moneda =  $request->moneda;
        //Se comprueba que se guarden la compra y sus datos de pago
        if (!($compra->save())) {
            return redirect()->back()->with('error', 'Error al guardar la compra.');
        }else {
            $pago->compra_id =  $compra->id;
            if (!($pago->save())) {
                $compra->delete();
                return redirect()->back()->with('error', 'Error con la información de pago.');
            }
        }


        //Comienzo de mapeo de cada producto
        foreach ($request->mercancias as $indice => $mercancia) {
            
            if ($request->proveedorselect[$indice] == "nuevo") {     //si es un proveedor nuevo
                $proveedor = new Provider;
                $proveedor->nombre = $request->proveedor[$indice];
                $proveedor->url = $request->url[$indice];
                $proveedor->save();
                $provider_id = $proveedor->id;
            }else {                                                 //si es un proveedor existente
                $provider_id = $request->proveedorselect[$indice];
            }
            if ($mercancia == "nuevo") {    //si es un producto nuevo
                //espacio para guardado de imágenes
                $producto = new Producto;
                $producto->codigo = $request->codigo[$indice];
                $producto->nombre = $request->nombre[$indice];
                $producto->provider_id = $provider_id;    //id de proveedor
                $producto->descripcion = $request->descripcion[$indice];
                $producto->precio = $request->precio[$indice];
                $producto->save();
                array_push($prod_arr, $request->nombre[$indice]);
            }else {     //si es un producto existente
                $producto = Producto::find($mercancia);
                $producto->provider_id = $provider_id;    //id de proveedor
                $producto->precio = $request->precio[$indice];
                $producto->save();
            }

            foreach ($request->talla[$indice] as $key => $value) {
                $talla = new Talla_cantidad_compra;
                $talla->compra_id = $compra->id;
                $talla->producto_id = $producto->id;
                $talla->talla = $value;
                $talla->cantidad = $request->cantidad[$indice][$key];
                $talla->precio = $request->unidad[$indice][$key];
                $talla->provider_id = $provider_id;
                $talla->save();
            }


        }   //Fin de mapeo de cada producto

        if ($request->hasFile('imagen')) {
            $offset = 0;
            $count_p = array();
            foreach ($request->file('imagen') as $item => $imagen) {
                $filename = $prod_arr[$offset] . "." . $imagen->extension();
                $imagen->move(public_path('imagenes'), $filename);
                $files[] = $filename;
                array_push($count_p, $filename);
                $offset++;
            }
        }

        return redirect()->route('inventario.index')->with('success', 'Información de compra guardada.');
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
