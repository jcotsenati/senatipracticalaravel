<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Database\QueryException;
use App\Utils\LogHelper;

class AlumnoController extends Controller
{    
    public function index()
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }
        $alumnos = Alumno::orderBy('id','desc')->paginate(2);
        return view('alumnos.index', compact('alumnos'));
    }
    public function show($id)
    {   
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }

        $page = request()->query('page', 1);
        $alumno = Alumno::findOrFail($id);
        return view('alumnos.show', compact('alumno','page'));
    }
    public function create(Request $request)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }

        return view('alumnos.create');
    }
    public function store(Request $request)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }
        
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => 'required|digits:8|unique:alumnos,dni',
        ]);

        try{
            Alumno::create($request->all());
            return redirect()->route('alumnos.index')->with('mensaje', 'Operacion Satisfactoria !!!');

        }catch(QueryException $e){

            LogHelper::logError($this,$e);

            $fechaHoraActual = date("Y-m-d H:i:s");
            $mensaje=$fechaHoraActual.' No se puede crear el registro';

            return redirect()->route('alumnos.create')->with('mensaje', $mensaje);
        }
    }
    public function edit($id)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }

        $page = request()->query('page', 1);
        $alumno = Alumno::findOrFail($id);
        return view('alumnos.edit', compact('alumno','page'));
    }
    public function update(Request $request, $id)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }
        
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => 'required|digits:8|unique:alumnos,dni,'.$id
        ]);

        $page = request()->query('page', 1);
        $alumno = Alumno::findOrFail($id);
        
        try{
            $alumno->update([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
            ]);

            return redirect()->route('alumnos.index',['page'=>$page])->with('mensaje', 'Operacion Satisfactoria !!!');

        }catch(QueryException $e){

            LogHelper::logError($this,$e);

            $fechaHoraActual = date("Y-m-d H:i:s");
            $mensaje=$fechaHoraActual.' No se puede actualizar el registro';
            
            return redirect()->route('alumnos.edit', [$id,'page'=>$page])->with('mensaje', $mensaje);
        }
    
    }
    public function destroy($id)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }

        $page = request()->query('page', 1);

        try{

            $alumno = Alumno::findOrFail($id);
            $alumno->delete();

            return redirect()->route('alumnos.index',['page'=>$page])->with('mensaje', 'Eliminacion satisfactoria !!!');
        
        }catch(QueryException $e){

            LogHelper::logError($this,$e);

            $errorCode = $e->getCode();

            if ($errorCode === '23000') {
                $fechaHoraActual = date("Y-m-d H:i:s");
                $mensaje=$fechaHoraActual.' No se puede eliminar, el Registro esta referenciado';
                
            }
            else{
                $fechaHoraActual = date("Y-m-d H:i:s");
                $mensaje=$fechaHoraActual.' No se puede eliminar el Registro !!!';
            
            }
            
            return redirect()->route('alumnos.index',['page'=>$page])->with('mensaje',$mensaje);
        }
        
    }
}
