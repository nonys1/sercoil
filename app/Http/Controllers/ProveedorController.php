<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;

class ProveedorController extends Controller
{
    public function index(){
    	$proveedores=Proveedor::orderBy('ID_PROV','DESC')->get();
    	return view('proveedor.index')->with('proveedores',$proveedores);
    }
    public function store(Request $request){
    	$proveedor=new Proveedor;
    	$proveedor->NOM_PROV=$request->nom_prov;
        $proveedor->DIR_PROV=$request->dir_prov;
        $proveedor->EMAIL_PROV=$request->email_prov;
    	$proveedor->DES_PROV=$request->des_prov;
    	$proveedor->TEL_PROV=$request->tel_prov;
    	$proveedor->save();
    	$exito='El proveedor se REGISTRO exitosamente!';
    	return redirect()->route('proveedor.index')->with('exito',$exito);
    }
    public function update(Request $request){
        $proveedor=Proveedor::Find($request->id_prov);
        $proveedor->NOM_PROV=$request->nom_prov_u;
        $proveedor->DIR_PROV=$request->dir_prov_u;
        $proveedor->TEL_PROV=$request->tel_prov_u;
         $proveedor->EMAIL_PROV=$request->email_prov_u;
        $proveedor->DES_PROV=$request->des_prov_u;
        $proveedor->save();
        $exito='El proveedor se ACTUALIZO exitosamente!';
        return redirect()->route('proveedor.index')->with('exito',$exito);
    }
}
