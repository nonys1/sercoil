<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Permission;
use App\Role;

class PermisoController extends Controller
{
    public function index(){
    	$permisos=Permission::get();
    	return view('permiso.index')->with('permisos',$permisos);
    }
}
