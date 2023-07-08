<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Permission;
use App\Role;

class UserController extends Controller
{
    public function index(){
    	$usuarios=User::join('role_user','role_user.user_id','=','users.ID_USU')->join('roles','roles.id','=','role_user.role_id')->orderBy('ID_USU','DESC')->get();
    	$roles=Role::orderBy('id','desc')->get();
    	return view('usuario.index')->with('usuarios',$usuarios)->with('roles',$roles);
    }
    public function store(Request $request){
        if (User::where('CI_USU',$request->ci_usu)->exists()) {
            $error='El numero de ci: '.$request->ci_usu.' ya se encuentra registrado';
            return redirect()->back()->with('error',$error)->withInput();
        }
        if (User::where('USU_USU',$request->usu_usu)->exists()) {
            $error='El nombre de usuario: '.$request->usu_usu.' ya se encuentra registrado';
            return redirect()->back()->with('error',$error)->withInput();
        }
    	$usuario=new User;
    	$usuario->NOM_USU=$request->nom_usu;
    	$usuario->PAT_USU=$request->pat_usu;
    	$usuario->MAT_USU=$request->mat_usu;
    	$usuario->CI_USU=$request->ci_usu;
    	$usuario->EXP_USU=$request->exp_usu;
    	$usuario->email=$request->email;
    	$usuario->USU_USU=$request->usu_usu;
    	$usuario->password=bcrypt($request->password);
    	$usuario->DIR_USU=$request->dir_usu;
    	$usuario->CEL_USU=$request->tel_usu;
    	$usuario->save();

    	$usuario->attachRole($request->id_rol);
    	$exito='EL USUARIO se registro exitosamente!';
    	return redirect()->route('usuario.index')->with('exito',$exito);
    }

    public function update(Request $request){
        $usuario=User::Find($request->id_usu);
        $usuario->NOM_USU=$request->nom_usu_u;
        $usuario->PAT_USU=$request->pat_usu_u;
        $usuario->MAT_USU=$request->mat_usu_u;
        $usuario->CI_USU=$request->ci_usu_u;
        $usuario->EXP_USU=$request->exp_usu_u;
        $usuario->email=$request->email_u;
        $usuario->USU_USU=$request->usu_usu_u;
        if ($request->password_u!='') {
            $usuario->password=bcrypt($request->password_u);
        }
        $usuario->DIR_USU=$request->dir_usu_u;
        $usuario->CEL_USU=$request->tel_usu_u;
        $usuario->save();

        $usuario->detachRoles($usuario->roles);
        $usuario->attachRole($request->id_rol_u);
        $exito='Los datos del USUARIO se ACTUALIZARON exitosamente!';
        return redirect()->route('usuario.index')->with('exito',$exito);
    }
}
