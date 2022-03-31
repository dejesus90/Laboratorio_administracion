<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use DB;
use App\Models as modelosLab;
use Illuminate\Support\Facades\Auth;

class pacienteController extends Controller
{
    
    public function buscarResultado(Request $request)
    {
        // return $request;
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);
        $pacientesLista = DB::table('pacientes')
            ->rightJoin('muestras', 'pacientes.id', '=', 'muestras.paciente_id')
            ->where('pacientes.tipo_identificacion','=',$request->tipoide)
            ->where('pacientes.cedula','=',$request->cedula)
            ->where('muestras.codigo_muestra','=',$request->codigo)
            ->select('pacientes.id','pacientes.nombre1','pacientes.cedula','muestras.id as idmuestra','muestras.archivo_adjunto')
            ->get();
        if($pacientesLista){
            $path = storage_path().'\\'.'app'.'\\public\\resultados\\'.$pacientesLista[0]->archivo_adjunto;
            if (file_exists($path)) {
                return response()->download($path);
            }
        }
        // return $pacientesLista;
   
       
    }

      
    
}