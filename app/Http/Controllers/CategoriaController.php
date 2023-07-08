<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{
    public function index(){
    	$categorias=Categoria::orderBy('ID_CAT','DESC')->get();
    	return view('categoria.index')->with('categorias',$categorias);
    }
    public function store(Request $request){
        if (Categoria::where('NOM_CAT',$request->nom_cat)->exists()) {
            $error='La categoria '.$request->nom_cat.' ya se encuentra registrada';
            return redirect()->route('categoria.index')->with('error',$error);
        }
        $categoria=new Categoria;
        $categoria->NOM_CAT=$request->nom_cat;
        $categoria->DES_CAT=$request->des_cat;
        $categoria->save();
        $exito='La CATEGORIA se registro exitosamente!';
        return redirect()->route('categoria.index')->with('exito',$exito);
    }
    public function update(Request $request){
        
        $categoria=Categoria::Find($request->id_cat);
        $categoria->NOM_CAT=$request->nom_cat_u;
        $categoria->DES_CAT=$request->des_cat_u;
        $categoria->save();
        $exito='La CATEGORIA se ACTUALIZO exitosamente!';
        return redirect()->route('categoria.index')->with('exito',$exito);
    }
}
