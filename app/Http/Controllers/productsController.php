<?php

namespace App\Http\Controllers;

use App\Exports\productsModelExport;
use App\Models\productsModel;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class productsController extends Controller
{
    public function index()
    {
        $products = productsModel ::all();
        return $products;
    }

    public function get_products(Request $request)
    {

        if ($request->ajax()) {
            extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending', 'byColumn', 'sort']));
            // $json = json_decode($query);

            // $verificar = $this->verificar_estados();

            $products = productsModel::select('*');

            if (isset($json->descripcion)) {
                $products->where('clave', 'LIKE', "%{$json->clave}%");
            }

            $result['count'] = $products->count();

            if (isset($orderBy)) {
                $direction = $ascending == 1 ? 'ASC' : 'DESC';
                $products->orderBy($orderBy, $direction);
            }
            // $result['verificar'] = $verificar;
            $result["data"] = $products->take($limit)->skip($limit * ($page - 1))->get();
            $result["limit"] = $limit * ($page - 1);
            return $result;
        }
    }

    public function store(Request $request)
    {
        try {

            $articulos_s = $request->articulos;

            foreach ($articulos_s as $item) {
                $art = new productsModel();
                $art->clave = $item['art_clave'];
                $art->categoria = $item['art_categoria'];
                $art->producto = $item['art_producto'];
                $art->precio = $item['art_precio'];
                $art->save();
            }

            $result['status'] = true;
        } catch (Exception $e) {
            $result['status'] = false;
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    public function tabla_export()
    {
        return view('tablaExport');
    }

    public function export()
    {
        return FacadesExcel::download(new productsModelExport , 'producs.xlsx');
    }

    public function dup(Request $request)
    {
        try {

            $dup = productsModel::where('products.clave',$request->clave)->get();

            if(count($dup) > 0){

                $result['status'] = true;
                $result['msg'] = "Ya existe un producto con esa clave";

            }else{
                $result['status'] = false;
            }


        } catch (Exception $e) {
            $result['status'] = false;
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }
}
