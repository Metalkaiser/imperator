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
        $compras = Compra::orderBy('created_at')->paginate(20);
        return view('compras.index', ['compras' => $compras]);
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
        $productos = $tallas = array();
        foreach ($compra->compras as $indice => $talla) {
            array_push($productos, $talla->productos->id);
        }
        $productos = array_unique($productos);

        foreach ($productos as $key => $id) {
            $tallas[$id] = Talla_cantidad_compra::where([
                ['producto_id',$id],
                ['compra_id',$compra->id]
            ])->get();
        }

        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
        $fecha = $dias[date('w',strtotime($compra->created_at))]
        . ", " . date('d',strtotime($compra->created_at))
        . " de "
        . $meses[date('n',strtotime($compra->created_at))-1]
        . " del " . date('Y',strtotime($compra->created_at));

        $desglose = "";
        $res = "<div><div><table class=\"table table-hover\"><thead><tr class=\"table-info\"><th>Fecha</th><th>Plataforma de pago</th><th>Total</th><th>Moneda</th><th>Casillero</th><th>Estado</th></tr></thead><tbody><tr>"."<td>".$fecha."</td><td>".$compra->pagos->tipo."</td><td>".$compra->total."</td><td>".$compra->pagos->moneda."</td><td>".$compra->carrier->casillero."</td><td>".($compra->status == "Tienda" ? "En inventario" : $compra->status)."</td></tr></tbody></table></div>";

        foreach ($productos as $index => $id) {
            $producto = Producto::find($id);
            $desglose = $desglose . "<div><div><h4>".$producto->codigo." ".$producto->nombre."</h4><h5>Proveedor: ".$producto->provider->nombre."</h5></div><table class=\"table table-hover table-sm table-bordered\"><thead><tr><th>Talla</th><th>Cantidad</th><th>Defectuosos</th><th>Precio por unidad (China)</th></tr></thead><tbody>";
            foreach ($tallas[$id] as $key => $value) {
                $desglose = $desglose . "<tr><td>".($value->talla == 0 ? "Varias" : $value->talla)."</td><td>".$value->cantidad."</td><td>".$value->defectuosos."</td><td>".$value->precio."</td></tr>";
            }
             $desglose = $desglose . "</tbody></table></div>";
        }

        return response()->json($res . $desglose ."</div>");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $compra = Compra::find($id);
        $p_ids = array();
        foreach ($compra->compras as $indice => $talla) {
            array_push($p_ids, $talla->productos->id);
        }
        $p_ids = array_unique($p_ids);

        $productos = Producto::whereIn('id',$p_ids)->get();
        return view('compras.edit', [
            'compra' => $compra,
            'productos' => $productos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $compra = Compra::find($id);
        if (isset($request->talla)) {
            foreach ($request->talla as $key => $value) {
                if ($request->defectuosos[$key] == "") {
                    return redirect()->back()->with('error', 'Llene todos los campos que haya marcado.');
                }
                $talla_defectuosa = Talla_cantidad_compra::find($key);
                $talla_defectuosa->defectuosos = $request->defectuosos[$key];
                $talla_defectuosa->save();
            }
        }
        $compra->status = $request->status;
        $compra->save();
        return redirect()->route('compras.index')->with('success', 'Cambios guardados.');
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
