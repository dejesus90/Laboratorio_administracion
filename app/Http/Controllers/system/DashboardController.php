<?php
namespace App\Http\Controllers\system;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\Paises;
use App\Models as modelosLab;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 0 pendientes, 1 activos , 2 rechazados
        $labPendientes = modelosLab\Laboratorio::with('paisLab')->where('activo', 0)->orderBy('nombre')->get();
        $labactivos = modelosLab\Laboratorio::with('paisLab')->where('activo', 1)->orderBy('nombre')->get();
        $labrechazados = modelosLab\Laboratorio::with('paisLab')->where('activo', 2)->orderBy('nombre')->get();
        return view('System.dashboard',["data"=>$labPendientes,"activos"=>$labactivos,"rechazados"=>$labrechazados]);
    }
    public function validateLab($id)
    {   
        $datalaboratorio = modelosLab\Laboratorio::with('paisLab.estados','infousuario')->where('id', $id)->first();
        return view('System.validar_laboratorio',["datalab"=>$datalaboratorio]);
    }
    public function activarlaboratorio(Request $request)
    {
        # code...
        $laboratorio = modelosLab\Laboratorio::whereId($request->id)->update(['activo'=>1]);
        $usuarios = modelosLab\Usuarioinfo::where('laboratorio__id',$request->id)->update(['activo'=>1]);
        $users = modelosLab\Usuarioinfo::where('laboratorio__id',$request->id)->get();
        foreach ($users as  $value) {
            # code...
            modelosLab\User::where('usuarioinfo_id',$value->id)->update(['activo'=>1]);
        }
        return json_encode([
            "estatus" => 'ok',
            "laboratorio"=> $request->id
        ]);
    }
    public function labActivos()
    {
        // 0 pendientes, 1 activos , 2 rechazados
        $labPendientes = modelosLab\Laboratorio::with('paisLab')->where('activo', 0)->orderBy('nombre')->get();
        $labactivos = modelosLab\Laboratorio::with('paisLab')->where('activo', 1)->orderBy('nombre')->get();
        $labrechazados = modelosLab\Laboratorio::with('paisLab')->where('activo', 2)->orderBy('nombre')->get();
        return view('System.labActivos',["data"=>$labPendientes,"activos"=>$labactivos,"rechazados"=>$labrechazados]);
    }
    public function labrechazados()
    {
        // 0 pendientes, 1 activos , 2 rechazados
        $labPendientes = modelosLab\Laboratorio::with('paisLab')->where('activo', 0)->orderBy('nombre')->get();
        $labactivos = modelosLab\Laboratorio::with('paisLab')->where('activo', 1)->orderBy('nombre')->get();
        $labrechazados = modelosLab\Laboratorio::with('paisLab','rechazados')->where('activo', 2)->orderBy('nombre')->get();
        return view('System.labrechazados',["data"=>$labPendientes,"activos"=>$labactivos,"rechazados"=>$labrechazados]);
    }
    public function download($tipo,$name)
    {
        $file = ($tipo == 1) ? 'ruts' :'comercio';
        $path = storage_path().'\\'.'app'.'\\public\\'.$file.'\\'.$name;
        if (file_exists($path)) {
            return response()->download($path);
        }
    }
    public function rechazarMuestra(Request $request)
    {
        # code... 
        $labRechazado = modelosLab\Laboratoriosrechazados::create([
            'id_laboratorio' => $request->idlab,
            'motivo' => $request->motivo
        ]);
        modelosLab\Laboratorio::whereId($request->idlab)->update(['activo'=>2]);

        return json_encode([
            "estatus" => 'ok',
            "laboratorio"=> $labRechazado->id
        ]);
    }
    
}