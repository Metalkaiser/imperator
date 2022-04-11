<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

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
        $lista = Producto::paginate(20);
        $arrTalla = $cantidadTallas = array();

        /*  Comienza Listado de tallas por producto    */
        foreach ($lista as $indice => $productos) {
            foreach ($productos->compras as $key => $value) {
                //Se definen las tallas de cada producto
                $arrTalla[$productos->codigo][$key] = $value->talla;
                if (array_key_exists($productos->codigo, $cantidadTallas) && array_key_exists($value->talla, $cantidadTallas[$productos->codigo])) {
                    $cantidadTallas[$productos->codigo][$value->talla] += $value->cantidad;
                }else {
                    $cantidadTallas[$productos->codigo][$value->talla] = $value->cantidad;
                }
            }
            $arrTalla[$productos->codigo] = array_unique($arrTalla[$productos->codigo]);
            sort($arrTalla[$productos->codigo]);
            $arrTalla[$productos->codigo] = implode(",", $arrTalla[$productos->codigo]);    
        /*  Termina Listado de tallas por producto    */
        }

        return view('inventario.index',
            [
                'productos' => $lista,
                'tallas' => $arrTalla,
                'cantidades' => $cantidadTallas
            ]);
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
    public function edit(Producto $producto)
    {
        //
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
}
