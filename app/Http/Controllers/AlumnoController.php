<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Database\QueryException;
use App\Utils\LogHelper;
use Illuminate\Support\Facades\Session;

class AlumnoController extends Controller
{    
    public function index()
    {
        $alumnos = Alumno::orderBy('id','desc')->paginate(2);
        return view('alumnos.index', compact('alumnos'));
    }
    public function show(Request $request,$id)
    {   
    
        $page = $request->query('page', 1);
        $alumno = Alumno::findOrFail($id);
        return view('alumnos.show', compact('alumno','page'));
    }
    public function create(Request $request)
    {
        
        return view('alumnos.create');
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => 'required|digits:8|unique:alumnos,dni',
        ]);

        try{
            Alumno::create($request->all());
            return redirect()->route('alumnos.index')->with('msn_sucess', 'Operacion Satisfactoria !!!');

        }catch(QueryException $e){

            LogHelper::logError($this,$e);

            $fechaHoraActual = date("Y-m-d H:i:s");
            $mensaje=$fechaHoraActual.' No se puede crear el registro';

            return redirect()->route('alumnos.create')->with('msn_error', $mensaje);
        }
    }
    public function edit($id)
    {
        
        $page = request()->query('page', 1);
        $alumno = Alumno::findOrFail($id);
        return view('alumnos.edit', compact('alumno','page'));
    }
    public function update(Request $request, $id)
    {
        
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

            return redirect()->route('alumnos.index',['page'=>$page])->with('msn_sucess', 'Operacion Satisfactoria !!!');

        }catch(QueryException $e){

            LogHelper::logError($this,$e);

            $fechaHoraActual = date("Y-m-d H:i:s");
            $mensaje=$fechaHoraActual.' No se puede actualizar el registro';
            
            return redirect()->route('alumnos.edit', [$id,'page'=>$page])->with('msn_error', $mensaje);
        }
    
    }
    public function destroy($id)
    {
    
        $page = request()->query('page', 1);

        try{

            $alumno = Alumno::findOrFail($id);
            $alumno->delete();

            return redirect()->route('alumnos.index',['page'=>$page])->with('msn_sucess', 'Eliminacion satisfactoria !!!');
        
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
            
            return redirect()->route('alumnos.index',['page'=>$page])->with('msn_error',$mensaje);
        }
        
    }
}
