<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\Promo;
use Illuminate\Support\Facades\Artisan;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de inventario en /inventario
     *  $arrTalla: string de tallas por producto
     *  $lista: listado de productos
     *  $cantidadTallas: cantidad en inventario por tallas
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->tallaslist();
        return view('inventario.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        return view('inventario.editar_producto', ['producto' => $producto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }


    /* Llama al comando artisan para hacer un respaldo
     * de la información en la base de datos.
     *
     * @return \Illuminate\Http\Response
     */
    public function dbbackup()
    {
        Artisan::call('database:backup');
        return response()->json('Respaldo de base de datos exitoso');
    }

    public function promos()
    {
        $promos = Promo::paginate(10);
        return view('inventario.promos', ['promos' => $promos]);
    }

    public function nuevapromo(Request $request)
    {
        $promo = new Promo;
        $promo->codigo = $request->codigo;
        $promo->nombre = $request->nombre;
        $promo->descripcion = $request->descripcion;
        $promo->inicio = $request->inicio;
        $promo->fin = $request->fin;
        if ($promo->save()) {
            return response()->json($promo);
        }else {
            return response()->json('Error','Error al intentar crear promoción',500);
        }
    }
    
}
