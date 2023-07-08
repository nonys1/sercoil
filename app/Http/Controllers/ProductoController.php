<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Categoria;
use App\Tipo;
use Carbon\Carbon;

class ProductoController extends Controller
{
    public function index(){
    	$productos=Producto::join('categoria','categoria.ID_CAT','=','producto.ID_CAT')->orderBy('ID_PRO','DESC')->get();
        $categorias=Categoria::get();
    	$tipos=Tipo::get();
    	return view('producto.index')->with('productos',$productos)->with('categorias',$categorias)->with('tipos',$tipos);
    }
    public function store(Request $request){
        if (Producto::where('NOM_PRO',$request->nom_pro)->exists()) {
            $error='El producto '.$request->nom_pro.' ya se encuentra registrado';
            return redirect()->route('producto.index')->with('error',$error);
        }
        dd($request);
    	$producto=new Producto;
    	$producto->COD_PRO=strtoupper(uniqid());
    	$producto->NOM_PRO=$request->nom_pro;
        $producto->PRE_COM=$request->pre_com;
    	$producto->PRE_PRO=$request->pre_ven;
    	$producto->DES_PRO=$request->des_pro;
        if ($request->file('img_pro')!='') {
            $imagen = $request->file('img_pro');
            $extension = $request->file('img_pro')->extension();
            $direccion=$imagen->storeAs('PRODUCTOS','PRO-'.Carbon::now()->format('Y-m-d_H-i-s').'.'.$extension,'mi_public');
            $producto->IMG_PRO=$direccion;
        }else{
            $error='Debe seleccionar una imagen para poder registrar el PRODUCTO!';
            return redirect()->route('producto.index')->with('error',$error);
        }
        $producto->ID_CAT=$request->id_cat;
    	$producto->ID_TIP=$request->id_tip;
    	$producto->save();
    	$exito='El producto se REGISTRO exitosamente!';
    	return redirect()->route('producto.index')->with('exito',$exito);
    }
    public function busca(Request $request){
        if ($request->ajax()) {
            $producto=Producto::Find($request->id_pro);
            return response()->json($producto);
        }
    }
    public function update(Request $request){
        $producto=Producto::find($request->id_pro);
        $producto->NOM_PRO=$request->nom_pro_u;
        $producto->PRE_COM=$request->pre_com_u;
        $producto->PRE_PRO=$request->pre_ven_u;
        $producto->DES_PRO=$request->des_pro_u;
        if ($request->file('img_pro_u')!='') {
            $imagen = $request->file('img_pro_u');
            $extension = $request->file('img_pro_u')->extension();
            $direccion=$imagen->storeAs('PRODUCTOS','PRO-'.Carbon::now()->format('Y-m-d_H-i-s').'.'.$extension,'mi_public');
            $producto->IMG_PRO=$direccion;
        }
        $producto->ID_CAT=$request->id_cat_u;
        $producto->ID_TIP=$request->id_tip_u;
        $producto->save();
        $exito='El producto se ACTUALIZO exitosamente!';
        return redirect()->route('producto.index')->with('exito',$exito);
    }
}
