<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller
{
    public function buscaCedula(Request $request){
    	if ($request->ajax()) {
    		$cliente=Cliente::where('CI_CLI',$request->ci_cli)->first();
    		if ($cliente) {
    			return response()->json($cliente);
    		}else{
                 return response()->json('FALSE');
    		}
    	}
    }

	public function index(){
		$cliente=Cliente::orderBy('ID_CLI','DESC')->get();
    	return view('cliente.index')->with('clientes',$cliente);
    }

	public function store(Request $request){
        $cliente=new Cliente;
        $cliente->CI_CLI=$request->ci_cli2;
        $cliente->EXP_CLI=$request->exp_cli;
        $cliente->NOM_CLI=$request->nom_cli;
        $cliente->PAT_CLI=$request->pat_cli;
        $cliente->MAT_CLI=$request->mat_cli;
        $cliente->FEC_NAC=$request->fec_nac;
        $cliente->DIR_CLI=$request->dir_cli;
        $cliente->TEL_CLI=$request->tel_cli;
        $cliente->EMAIL_CLI=$request->email_cli;

        $cliente->save();
        $exito='La CLIENTE se registro exitosamente!';
        return redirect()->route('cliente.index')->with('exito',$exito);
    }

	public function update(Request $request){
        $cliente=Cliente::Find($request->id_cli);
		
        $cliente->CI_CLI=$request->ci_cli2;
        $cliente->EXP_CLI=$request->exp_cli;
        $cliente->NOM_CLI=$request->nom_cli;
        $cliente->PAT_CLI=$request->pat_cli;
        $cliente->MAT_CLI=$request->mat_cli;
        $cliente->FEC_NAC=$request->fec_nac;
        $cliente->DIR_CLI=$request->dir_cli;
        $cliente->TEL_CLI=$request->tel_cli;
        $cliente->EMAIL_CLI=$request->email_cli;

        $cliente->save();
        $exito='La CLIENTE se ACTUALIZO exitosamente!';
        return redirect()->route('cliente.index')->with('exito',$exito);
    }

}
