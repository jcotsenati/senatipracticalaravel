<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Database\QueryException;

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

        if($request->alumno){
    
            $alumno=(object)$request->alumno;
            return view('alumnos.create',compact('alumno'));
        }
        else
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
            'dni' => 'required|size:8|unique:alumnos,dni',
        ]);
        try{
            Alumno::create($request->all());

            return redirect()->route('alumnos.index')->with('mensaje', 'Operacion Satisfactoria !!!');

        }catch(QueryException $e){
            $errorCode = $e->getCode();
            $alumno=[
                'dni'=>$request->dni,
                'nombres'=>$request->nombres,
                'apellidos'=>$request->apellidos
            ];
            
            $mensaje="";
            if ($errorCode === '23000') {

                $mensaje='El registro tiene un campo duplicado';
            }
            else if ($errorCode === '22001') {

                $mensaje='El registro tiene un campo mas grande de lo esperado';
            }
            else{

                $mensaje='No se puede crear el registro';
            }

            return redirect()->route('alumnos.create',compact('alumno'))->with('mensaje', $mensaje);
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
            'dni' => 'required',
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

            $errorCode = $e->getCode();
            
            $mensaje="";
            if ($errorCode === '23000') {

                $mensaje='El registro tiene un campo duplicado';
            }
            else if ($errorCode === '22001') {

                $mensaje='El registro tiene un campo mas grande de lo esperado';
            }
            else{

                $mensaje='No se puede crear el registro';
            }

            $alumno=[
                'id'=>$id,
                'dni'=>$request->dni,
                'nombres'=>$request->nombres,
                'apellidos'=>$request->apellidos
            ];
            $alumno=(object)$alumno;
            
            return view('alumnos.edit', compact('alumno'))->with('mensaje', $mensaje);
        }
    
    }
    public function destroy($id)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }
        try{

            $alumno = Alumno::findOrFail($id);
            $alumno->delete();

            return redirect()->route('alumnos.index')->with('mensaje', 'Eliminacion satisfactoria !!!');
        
        }catch(QueryException $e){
            $errorCode = $e->getCode();

            if ($errorCode === '23000') {

                return redirect()->route('alumnos.index')->with('mensaje', 'No se puede eliminar, el Registro esta referenciado');
            }
            else{

                return redirect()->route('alumnos.index')->with('mensaje', 'No se puede eliminar el Registro !!!');
            }
            
        }
        
    }
}
