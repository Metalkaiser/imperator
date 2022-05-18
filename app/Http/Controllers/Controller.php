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
            ->select('compras.id as compras','productos.id as productos')
            ->get();

        $ids = $c_ids = [];
        foreach ($coincidencias as $coincidencia) {
            array_push($ids, $coincidencia->productos);
            array_push($c_ids, $coincidencia->compras);
        }
        $promos = Promo::all();
        $pagina = Producto::orderBy('nombre')->paginate(10);
        $lista = Producto::orderBy('nombre')->get();
        $arrTalla = $cantidadTallas = $optTallas = array();

        /*  Comienza Listado de tallas por producto    */
        foreach ($lista as $indice => $productos) {     //Cada registro en la tabla productos
            foreach ($productos->compras as $key => $value) {   //Cada compra por producto
                //Se definen las tallas de cada producto
                $arrTalla[$productos->codigo][$key] = $value->talla;
                $optTallas[$productos->id][$key] = $value->talla;
                if (array_key_exists($productos->id, $cantidadTallas) && array_key_exists($value->talla, $cantidadTallas[$productos->id])) {

                    if (in_array($value->producto_id, $ids) && in_array($value->compra_id, $c_ids)) {
                        $cantidadTallas[$productos->id][$value->talla] += $value->cantidad;
                        //$cantidadTallas[$productos->id][$value->talla] -= $value->defectuosos;
                    }else {
                        $cantidadTallas[$productos->id][$value->talla] += 0;
                    }
                }else {
                    if (in_array($value->producto_id, $ids) && in_array($value->compra_id, $c_ids)) {
                        $cantidadTallas[$productos->id][$value->talla] = $value->cantidad;
                        //$cantidadTallas[$productos->id][$value->talla] -= $value->defectuosos;
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
            'productos' => $lista,              //Lista de productos en el inventario
            'paginas' => $pagina,               //Lista paginada de productos
            'tallas' => $arrTalla,              //String de tallas totales por producto
            'cantidades' => $cantidadTallas,    //Cantidades disponibles por talla, por producto
            'opciones' => $optTallas,           //Array de tallas por producto
            'promos' => $promos,                //Promociones en la DB
        ];
    }
}
