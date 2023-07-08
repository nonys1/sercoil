<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Producto;
use App\Venta;
use App\User;
use Carbon\Carbon;

use App\Mail\TestEmail;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $agotados=Producto::where('EXT_PRO','<',20)->orderBy('EXT_PRO','ASC')->get();
        $usuarios=User::join('role_user','role_user.user_id','=','users.ID_USU')->join('roles','roles.id','=','role_user.role_id')->get();
        $ventas_mes=Venta::whereMonth('FEC_VEN',Carbon::now()->format('m'))->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')->join('users','users.ID_USU','=','venta.ID_USU')->orderBy('ID_VEN','DESC')->get();
        $asignados=Venta::where('ID_USU_ENC',Auth::user()->ID_USU)
        ->join('users','users.ID_USU','=','venta.ID_USU')
        ->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')
        ->where('EST_VEN',1)->get();
        return view('home.index')->with('agotados',$agotados)->with('usuarios',$usuarios)->with('ventas_mes',$ventas_mes)->with('asignados',$asignados);
    }

    public function codigo(){
        /*$ventas=Venta::get();
        foreach ($ventas as $venta) {
            $codigo=strtoupper(uniqid($venta->ID_VEN));
            $nuevo=Venta::find($venta->ID_VEN);
            $nuevo->COD_VEN=$codigo;
            $nuevo->save();
        }
        echo "CODIGOS AGREGADOS";*/

        /*$ventas=Venta::get();
        foreach ($ventas as $venta) {
            $nuevo=Venta::find($venta->ID_VEN);
            $nuevo->FEC_ENV=$nuevo->FEC_VEN;
            $nuevo->save();
        }
        echo "FECHA DE ENVIO ASIGNADOS";*/


        /*$data = ['content' => 'This is a test!'];
        $subject = ['subject' => 'SERCOIL'];
        Mail::to('josecarl777@gmail.com')->send(new TestEmail($data,$subject));
        echo "correo enviado";*/

        /*$productos=Producto::get();
        foreach ($productos as $producto) {
            $nuevo=Producto::find($producto->ID_PRO);
            $nuevo->PRE_COM=($nuevo->PRE_PRO-5);
            $nuevo->save();
        }
        echo "PRECIOS DE COMPRA MODIFICADOS";*/
    }
}
