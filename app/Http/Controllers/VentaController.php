<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Promo;
use App\Models\Pago_venta;
use App\Models\Envio_venta;
use App\Models\Talla_cantidad_venta;
use App\Http\Controllers\ProductoController;

class VentaController extends Controller
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
        $data = $this->tallaslist();
        return view('ventas.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Crear nueva venta
        $venta = new Venta;
        $venta->nombre_cliente = $request->ncliente;
        $venta->ciudad_cliente = $request->ccliente;
        $venta->telefono_cliente = $request->tcliente;
        $venta->plataforma_id = $request->plataforma;
        if ($request->plataforma == "2") {  //Si es enviado por mercadolibre
            $venta->comision_ml = 1;
        }else {
            $venta->comision_ml = 0;
        }
        if (isset($request->promoselect) && $request->promoselect == "Sí") {    //Si es promoción
            $venta->promo_id = $request->promo;
        }
        $venta->status = $request->status;

        if ($venta->save()) {   //Se guarda la venta
            $pago_venta = new Pago_venta;
            $pago_venta->venta_id = $venta->id;
            $pago_venta->plat_pago = $request->pago;
            if ($request->pago != "bolivares" && $request->pago != "dolares" && $request->pago != "Otro") {
                $pago_venta->referencia = $request->referencia;
            }
            $pago_venta->monto = $request->monto;
            $pago_venta->moneda = $request->moneda;
            if ($request->envioselect != "Entrega en persona" && $request->envioselect != "Otro") {
                $envio_venta = new Envio_venta;
                $envio_venta->venta_id = $venta->id;
                $envio_venta->empresa = $request->envioselect;
                $envio_venta->rastreo = $request->rastreo;
                $envio_venta->precio = $request->gastoenvio;
                if ($envio_venta->save()) {
                    $envio_check = true;
                }else {
                    $all_ok = false;
                    $envio_check = false;
                    $linea = 75;
                    $venta->delete();
                }
            }else {
                $envio_check = true;
            }
            if ($envio_check) {
                if ($pago_venta->save()) {
                    foreach ($request->mercancias as $indice => $mercancia) {
                        foreach ($request->talla[$indice] as $i => $talla) {
                            $tallas = new Talla_cantidad_venta;
                            $tallas->venta_id = $venta->id;
                            $tallas->producto_id = $mercancia;
                            $tallas->talla = $talla;
                            $tallas->cantidad = $request->cantidad[$indice][$i];
                            $tallas->precio = $request->precio[$indice];
                            if ($tallas->save()) {
                                $all_ok = true;
                            }else {
                                $all_ok = false;
                                $linea = 97;
                                $venta->delete();
                                if ($request->envioselect != "Entrega en persona" && $request->envioselect != "Otro") {
                                    $envio_venta->delete();
                                }
                                $pago_venta->delete();
                            }
                        }
                    }
                }else {
                    $all_ok = false;
                    $linea = 88;
                    $venta->delete();
                    if ($request->envioselect != "Entrega en persona" && $request->envioselect != "Otro") {
                        $envio_venta->delete();
                    }
                }
            }

        }else {
            $all_ok = false;
            $linea = 61;
        }

        if ($all_ok) {
            return redirect()->route('inventario.index')->with('success', 'Información de venta guardada.');
        }else {
            return redirect()->back()->with('error', 'Ha ocurrido un error. Línea ' . $linea);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }
}
