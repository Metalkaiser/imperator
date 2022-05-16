<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Promo;
use App\Models\Pago_venta;
use App\Models\Envio_venta;
use App\Models\Talla_cantidad_venta;
use App\Models\Plataforma;
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
        $ventas = Venta::orderBy('created_at')->paginate(20);
        return view('ventas.index', ['ventas' => $ventas]);
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
                $envio_venta = new Envio_venta;
                $envio_venta->venta_id = $venta->id;
                $envio_venta->empresa = $request->envioselect;
                if ($envio_venta->save()) {
                    $envio_check = true;
                }else {
                    $all_ok = false;
                    $envio_check = false;
                    $linea = 90;
                    $venta->delete();
                }
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
                                $linea = 109;
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
                    $linea = 100;
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
        $productos = $venta->productos;
        $plataforma = $venta->plataformas;
        $pago = $venta->pagos;
        $envio = $venta->envios;
        if ($venta->promo_id != "") {
            $promo = $venta->promociones;
        }else {
            $promo = "";
        }

        $tdtr = "</td></tr><tr><th>";
        $thtd = "</th><td>";
        $rows = "";

        $res = "<div><table class=\"table table-hover\"><tr><th>Nombre del cliente" . $thtd
        . $venta->nombre_cliente
        . $tdtr . "Ciudad del cliente" . $thtd
        . $venta->ciudad_cliente;
        if ($venta->telefono_cliente != "") {
            $res = $res . $tdtr . "Teléfono del cliente" . $thtd
            . $venta->telefono_cliente;
        }
        $res = $res . $tdtr . "Artículos comprados" . $thtd . "<table class=\"table table-hover\"><thead><tr><th>Producto</th><th>Tallas</th><th>Cantidades</th><th>Precio de venta</th></tr></thead><tbody>";

        foreach ($productos as $index => $producto) {
            $tallasStr = "";
            $cantidades = "";
            $precios = "";
            $tallas = $venta->ventas->where('producto_id', $producto->id);
            foreach ($tallas as $key => $talla) {
                if ($talla->producto_id == $producto->id) {
                    if ($talla->talla == 0) {
                        $tallasStr =  $tallasStr . "Varias";
                    }else {
                        $tallasStr =  $tallasStr . $talla->talla;
                    }
                    $cantidades = $cantidades . $talla->cantidad;
                    $precios = $precios . $talla->precio;
                    if ((count($tallas) - 1) > $key) {
                        $tallasStr = $tallasStr . " ,";
                        $cantidades = $cantidades . " ,";
                        $precios = $precios . " ,";
                    }
                }
            }
            $rows = $rows . "<tr><td>" . $producto->nombre . "</td><td>" . $tallasStr . "</td><td>" . $cantidades . "</td><td>" . $precios . "</td></tr>";
        }

        $detalles = "<tr><th>Plataforma de contacto</th><td>"
        . $plataforma->nombre . "</td></tr><tr><th>Forma de pago</th><td>"
        . $pago->plat_pago . "</td></tr><tr><th>Monto pagado</th><td>"
        . $pago->monto . "</td></tr><tr><th>Moneda</th><td>"
        . $pago->moneda;

        if ($pago->plat_pago != "bolivares" && $pago->plat_pago != "dolares" && $pago->plat_pago != "Otro") {
            $detalles = $detalles . "</td></tr><tr><th>Referencia de pago</th><td>"
            . $pago->referencia;
        }else {
            $detalles = $detalles . "</td></tr><tr><th>Referencia de pago</th><td>"
            . "Efectivo u otro";
        }
        $detalles = $detalles . "</td></tr><tr><th>Estado de la venta</th><td>"
        . $venta->status . "</td></tr><tr><th>Forma de envío</th><td>"
        . $envio->empresa;

        if ($envio->empresa != "Entrega en persona" && $envio->empresa != "Otro") {
            $detalles = $detalles. "</td></tr><tr><th>Código de rastreo</th><td>"
            . $envio->rastreo . "</td></tr><tr><th>Precio de envío</th><td>"
            . $envio->precio . "</td></tr>";
        }

        if ($promo != "") {
            $detalles = $detalles . "<tr><th>Promoción</th><td>"
            . $promo->nombre . "</td></tr>";
        }

        $res = $res . $rows . "</tbody></table></td></tr>" . $detalles . "</table>
</div>";

        return response()->json([
            $res,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venta = Venta::find($id);
        if ($venta->promo_id != "") {
            $promo = $venta->promociones;
        }else {
            $promo = "";
        }
        return view('ventas.edit', [
            'venta' => $venta,
            'promo' => $promo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $venta = Venta::find($id);
        if (isset($request->empresa)) {
            $venta->envios->empresa = $request->empresa;
            $venta->envios->rastreo = $request->rastreo;
            $venta->envios->precio = $request->precio;
            $venta->envios->save();
        }
        $venta->status = $request->status;
        $venta->save();

        return redirect()->route('ventas.index');
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
