<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Paises;
use App\Models as modelosLab;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('Login.login');
    }  
      
    public function customLogin(Request $request)
    {
        // dd($request);
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        // $credentials = $request->only('email', 'password');
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'activo' => 1])) {
            return redirect()->intended('dashboard')->withSuccess('Signed in');
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        $data=Paises::
        with('estados')
        ->get();
        return view('Login.registration',['data' => $data]);
    }
      
    public function customRegistration(Request $request)
    {  
        // dd($request);
        $request->validate([
            'nombre' => 'required',
            'cedula' => 'required',
            'nombre_laboratorio' => 'required',
            'rut' => 'required',
            'documento_rut' => 'required|max:2048',
            'documento_comercio' => 'required|max:2048',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $fileName = time().'_'.$request->file('documento_rut')->getClientOriginalName();
        $filePath = $request->file('documento_rut')->storeAs('ruts', $fileName, 'public');

        $fileName_comercio= time().'_'.$request->file('documento_comercio')->getClientOriginalName();
        $filePath_comercio= $request->file('documento_comercio')->storeAs('comercio', $fileName, 'public');

        $data = $request->all();
        // resgistramos laboratorio
        $Laboratorio =  modelosLab\Laboratorio::create([
            'nombre' => $data['nombre_laboratorio'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono'],
            'rut' => $data['rut'],
            'comercio' => $data['comercio'],
            'pais_id' => $data['pais'],
            'estado_id' => $data['estado'],
            'zipcode' => $data['zipcode'],
            'file_rut' => $fileName,
            'file_comercio' => $fileName_comercio
        ]);
        // registramos data users
        $datauser = modelosLab\Usuarioinfo::create([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'cedula' => $data['cedula'],
            'cargo' => $data['cargo'],
            'email' => $data['email'],
            'laboratorio__id' => $Laboratorio->id,
            'rol_id' => 2,
            'tipousuario_id' => 2
        ]);
        // registrar usuario laboratorio
        // $datauserlab = modelosLab\Laboratoriouser::create([
        //     'usuario_id' => $Laboratorio->id,
        //     'laboratorio_id' => $datauser->id
        // ]);
        // registramos users
        User::create([
            'name' => $data['nombre'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'usuarioinfo_id' => $datauser->id,
            'rol_id'=> 2,
        ]);
        // return 'ok';
        // $check = $this->create($data);
         
        return redirect("login");
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('/');
    }
}