<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\Promo;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function tallaslist() {
        $coincidencias = DB::table('productos')
            ->join('talla_cantidad_compras as A', 'A.producto_id', '=', 'productos.id')
            ->join('compras', 'compras.id', '=', 'A.compra_id')
            ->where('compras.status','Tienda')
            ->select('productos.id')
            ->get();

        $ids = [];
        foreach ($coincidencias as $indice => $producto) {
            array_push($ids, $producto->id);
        }
        $promos = Promo::all();
        $lista = Producto::orderBy('nombre')->paginate(20);
        $arrTalla = $cantidadTallas = $optTallas = array();

        /*  Comienza Listado de tallas por producto    */
        foreach ($lista as $indice => $productos) {
            foreach ($productos->compras as $key => $value) {
                //Se definen las tallas de cada producto
                $arrTalla[$productos->codigo][$key] = $value->talla;
                $optTallas[$productos->id][$key] = $value->talla;
                if (array_key_exists($productos->codigo, $cantidadTallas) && array_key_exists($value->talla, $cantidadTallas[$productos->id])) {
                    if (in_array($value->producto_id, $ids)) {
                        $cantidadTallas[$productos->id][$value->talla] += $value->cantidad;
                        $cantidadTallas[$productos->id][$value->talla] -= $value->defectuosos;
                    }else {
                        $cantidadTallas[$productos->id][$value->talla] += 0;
                    }
                }else {
                    if (in_array($value->producto_id, $ids)) {
                        $cantidadTallas[$productos->id][$value->talla] = $value->cantidad;
                        $cantidadTallas[$productos->id][$value->talla] -= $value->defectuosos;
                    }else {
                        $cantidadTallas[$productos->id][$value->talla] = 0;
                    }
                }
            }
            foreach ($productos->ventas as $key => $value) {
                if (in_array($value->producto_id, $ids)) {
                    $cantidadTallas[$productos->id][$value->talla] -= $value->cantidad;
                }
            }
            //Comienza If de prueba
                if ($productos->compras == "[]") {
                    $arrTalla = $cantidadTallas = array();
                }else {
                    $arrTalla[$productos->codigo] = array_unique($arrTalla[$productos->codigo]);
                    $optTallas[$productos->id] = array_unique($optTallas[$productos->id]);
                    sort($optTallas[$productos->id]);
                    sort($arrTalla[$productos->codigo]);
                    $arrTalla[$productos->codigo] = implode(",", $arrTalla[$productos->codigo]);    
                }
            //Termina If de prueba
        /*  Termina Listado de tallas por producto    */
        }

        return [
            'productos' => $lista,
            'tallas' => $arrTalla,
            'cantidades' => $cantidadTallas,
            'opciones' => $optTallas,
            'promos' => $promos,
        ];
    }
}
