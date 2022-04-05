<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Hash;
use DB;
use App\Models\User;
use App\Models\Paises;
use App\Models as modelosLab;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
    public function index()
    {
        // dashborad administrador
        $infouser = modelosLab\Usuarioinfo::where('id',Auth::user()->usuarioinfo_id)->first();
        
        $usuariosLab = modelosLab\Usuarioinfo::where([['laboratorio__id',$infouser->laboratorio__id],['tipousuario_id',3]])->get();
        // dd($usuariosLab);
        $detalle = $this->filtroEncabezado();
        return view('Laboratory.dashboard',['mueestrasresumen'=>$detalle,'usuariosLab'=>$usuariosLab]);
    }
    public function pacientes()
    {
        # code...
        //
        $infouser = modelosLab\Usuarioinfo::where('id',Auth::user()->usuarioinfo_id)->first();
        
        //
        $pacientesLista = DB::table('pacientes')
            ->rightJoin('paciente_laboratorio', 'pacientes.id', '=', 'paciente_laboratorio.paciente_id')
            ->where('paciente_laboratorio.laboratorio_id','=',$infouser->laboratorio__id)
            ->select('pacientes.*')
            ->get();
        
        $detalle = $this->filtroEncabezado();
        return view('Laboratory.paciente',["pacientes"=>$pacientesLista,'mueestrasresumen'=>$detalle]);
    }
    public function registrarPaciente(Request $request)
    {
        # code...
        $datareq = $request->datas;
        $pacienteid = $datareq['nuevo'];
        if($datareq['nuevo'] == 0){
            $paciente = modelosLab\Pacientes::create([
                'nombre1' => $datareq['nombre1'],
                'nombre2' => $datareq['nombre2'],
                'apellidos' => $datareq['apellidos'],
                'cedula' => $datareq['cedula'],
                'email' =>  $datareq['email'],
                // 'password' => $datareq['password'],
                'telefono' => $datareq['telefono'],
                'tipo_identificacion' => $datareq['tipoide']
            ]);
            $pacienteid = $paciente->id;
        }
        else{

            modelosLab\Pacientes::where('id', $datareq['nuevo'])
            ->update([
                'nombre1' => $datareq['nombre1'],
                'nombre2' => $datareq['nombre2'],
                'apellidos' => $datareq['apellidos'],
                'email' =>  $datareq['email'],
                'telefono' => $datareq['telefono']
            ]);
        }
        
        
        // modelosLab\User::create([
        //     'name' => $datareq['nombre1'],
        //     'email' => $datareq['email'],
        //     'password' => Hash::make($datareq['password']),
        //     'activo' => 0,
        //     'usuarioinfo_id' => 0,
        //     'rol_id' => 4,
        // ]);

        $infouser = modelosLab\Usuarioinfo::where('id',Auth::user()->usuarioinfo_id)->first();
        modelosLab\PacienteLaboratorio::create([
            'paciente_id' => $pacienteid,
            'laboratorio_id' => $infouser->laboratorio__id,
        ]);

        modelosLab\Muestras::create([
            'codigo_muestra' => $this->generateRandomString(8), //$datareq['codigo'],
            'examen_id' => $datareq['analisis'],
            'paciente_id' => $pacienteid,
            'estado_id' => 1,
            'laboratorio_id' => $infouser->laboratorio__id,
            'usuario_id' => Auth::user()->id,
        ]);

        return json_encode([
            "estatus" => 'ok',
        ]);
    }
    public function buscarPaciente(Request $request)
    {
        # code...
        $paciente = modelosLab\Pacientes::where([['cedula',$request->cedula],['tipo_identificacion',$request->tipoide]]) ->first();
        return json_encode([
            "estatus"   => 'ok',
            "data"      => $paciente
        ]);
    }
    public function analisis()
    {
        # code...
        $infouser = modelosLab\Usuarioinfo::where('id',Auth::user()->usuarioinfo_id)->first();
        $muestrasLab = modelosLab\Muestras::with('estadomuestra','paciente','examen')
        ->where('laboratorio_id',$infouser->laboratorio__id)->get();
        
        $enlab = 0;
        $enanalisis = 0;
        $publicados = 0;
        foreach ($muestrasLab as $value) {
            # code...
            
            switch ($value->estadomuestra->id) {
                case 1: $enlab ++; break;
                case 2: $enanalisis ++; break;
                case 3: $publicados ++; break;
            }
        }
        $pacientesLista = DB::table('pacientes')
            ->rightJoin('paciente_laboratorio', 'pacientes.id', '=', 'paciente_laboratorio.paciente_id')
            ->where('paciente_laboratorio.laboratorio_id','=',$infouser->laboratorio__id)
            ->select('pacientes.*')
            ->get();
        $detalle = [
            'laboratorio' => $enlab,
            'analisis'  => $enanalisis,
            'publicados' => $publicados,
            'pacientes' => count($pacientesLista)
        ];
        $analisisLab = modelosLab\Examenes::orderBy('nombre')
        ->where('laboratorio_id',$infouser->laboratorio__id)->get();
        return view('Laboratory.examenes',["analisis"=>$analisisLab,'mueestrasresumen'=>$detalle]);
    }
    public function registrarExamen(Request $request)
    {
        # code...
        $infouser = modelosLab\Usuarioinfo::where('id',Auth::user()->usuarioinfo_id)->first();
        $datareq = $request->data;
        modelosLab\Examenes::create([
            'nombre' => $datareq['nombre'],
            'codigo' => $datareq['codigo'],
            'dias_resultado' => $datareq['diasres'],
            'laboratorio_id' => $infouser->laboratorio__id,
        ]);
        return json_encode([
            "estatus" => 'ok',
        ]);
    }
    public function muestras($tipo = 1)
    {
        // dd(Auth::user()->infoUser());
        $filtro = 1;
        switch ($tipo) {
            case 'laboratorio':
                $filtro = 1;
                break;
            case 'analisis':
                $filtro = 2;
                break;
            case 'publicados':
                $filtro = 3;
                break;
        }
        # code...
        $infouser = modelosLab\Usuarioinfo::where('id',Auth::user()->usuarioinfo_id)->first();
        
        $muestrasLab = modelosLab\Muestras::with('estadomuestra','paciente','examen')
        ->where([['laboratorio_id',$infouser->laboratorio__id],['estado_id',$filtro]])->get();
        $estados =  modelosLab\Estadomuestras::get();
        $detalle = $this->filtroEncabezado();
        return view('Laboratory.muestras',["muestras"=>$muestrasLab,"estados" => $estados,'mueestrasresumen'=>$detalle]);
    }
    public function registrarMuestra(Request $request)
    {
        # code...
        $datareq = $request->data;
        modelosLab\Muestras::create([
            'codigo_muestra' => $datareq['codigo'],
            'examen_id' => $datareq['analisis'],
            'paciente_id' => $datareq['paciente'],
            'estado_id' => $datareq['estado'],
            'laboratorio_id' => 5,
            'usuario_id' => Auth::user()->id,
        ]);

        return json_encode([
            "estatus" => 'ok',
        ]);
    }
    public function filtroEncabezado()
    {
        # code...
        $infouser = modelosLab\Usuarioinfo::where('id',Auth::user()->usuarioinfo_id)->first();
        $muestrasLab = modelosLab\Muestras::with('estadomuestra','paciente','examen')
        ->where('laboratorio_id',$infouser->laboratorio__id)->get();
        
        $enlab = 0;
        $enanalisis = 0;
        $publicados = 0;
        foreach ($muestrasLab as $value) {
            # code...
            
            switch ($value->estadomuestra->id) {
                case 1: $enlab ++; break;
                case 2: $enanalisis ++; break;
                case 3: $publicados ++; break;
            }
        }
        $pacientesLista = DB::table('pacientes')
            ->rightJoin('paciente_laboratorio', 'pacientes.id', '=', 'paciente_laboratorio.paciente_id')
            ->where('paciente_laboratorio.laboratorio_id','=',$infouser->laboratorio__id)
            ->select('pacientes.*')
            ->get();
        $analisisLab = modelosLab\Examenes::orderBy('nombre')
        ->where('laboratorio_id',$infouser->laboratorio__id)->get();
        $detalle = [
            'laboratorio' => $enlab,
            'analisis'  => $enanalisis,
            'examenes'  => $analisisLab,
            'publicados' => $publicados,
            'pacientes' => count($pacientesLista),
            'usuario'  => $infouser->tipousuario_id,
        ];
        return $detalle;
    }
    public function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function updateMuestra(Request $request)
    {
        # code...
        modelosLab\Muestras::where('id', $request->idmuestra)
        ->update([
            'estado_id' => $request->cambiar
        ]);
        return json_encode([
            "estatus" => 'ok',
        ]);
    }
    public function publicarMuestra(Request $request)
    {
        # code...
        // dd($request->idmuestra);
        $fileName = time().'_'.$request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('resultados', $fileName, 'public');
        modelosLab\Muestras::where('id', $request->idmuestra)
        ->update([
            'estado_id' => 3,
            'archivo_adjunto' => $fileName
        ]);
        return json_encode([
            "estatus" => 'ok',
        ]);
    }
    public function download($tipo)
    {
        
        try {
            $path = storage_path().'\\'.'app'.'\\public\\resultados\\'.$tipo;
            if (file_exists($path)) {
                return response()->download($path);
            }
        } catch (Exception $e) {
            return 'NOT FOUND';
        }
        // return $tipo;
        # code...
        // return Storage::download($request->filePath);
    }
    public function registrarUsuario(Request $request)
    {
        # code...
        $infouser = modelosLab\Usuarioinfo::where('id',Auth::user()->usuarioinfo_id)->first();
        $datauser = modelosLab\Usuarioinfo::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'cedula' => $request->cedula,
            'cargo' => $request->cargo,
            'email' => $request->email,
            'laboratorio__id' => $infouser->laboratorio__id,
            'rol_id' => 2,
            'tipousuario_id' => 3,
            'activo'    => 1,
        ]);

        User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usuarioinfo_id' => $datauser->id,
            'usuarioinfo_id' => $datauser->id,
            'rol_id'=> 2,
            'activo'    => 1,
        ]);
        return json_encode([
            "estatus" => 'ok',
        ]);
    }
    
    
}