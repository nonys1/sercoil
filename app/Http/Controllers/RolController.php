<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Permission;
use App\Role;

class RolController extends Controller
{
    public function index(){
    	$roles=Role::orderBy('id','desc')->get();
    	$permisos=Permission::get();
    	return view('rol.index')->with('roles',$roles)->with('permisos',$permisos);
    }

    public function store(Request $request){
    	$rol=new Role;
    	$rol->name=$request->name;
    	$rol->display_name=$request->display_name;
    	$rol->description=$request->description;
    	$rol->save();
    	if (isset($request->permisos)) {
    		foreach ($request->permisos as $permiso) {
	    		$rol->attachPermission($permiso);
	    	}
    	}
    	
    	$exito='Se registro el ROL exitosamente!';
    	return redirect()->route('rol.index')->with('exito',$exito);
    }
    public function busca(Request $request){
        if ($request->ajax()) {
            $rol=Role::Find($request->id_rol);
            $permisos=Permission::get();
            $asignados=$rol->perms()->get();

            $vector = array('rol' => $rol,'permisos' => $permisos,'asignados' => $asignados );
            return response()->json($vector);
        }
    }

    public function update(Request $request){
        $rol=Role::Find($request->id_rol);
        $rol->name=$request->name_u;
        $rol->display_name=$request->display_name_u;
        $rol->description=$request->description_u;
        $rol->save();
            $rol->detachPermissions($rol->perms);
        if (isset($request->permisos_u)) {
            foreach ($request->permisos_u as $permiso) {
                $rol->attachPermission($permiso);
            }
        }
        $exito='El ROL se ACTUALIZO exitosamente!';
        return redirect()->route('rol.index')->with('exito',$exito);
    }
}
