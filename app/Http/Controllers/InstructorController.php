<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Database\QueryException;

class InstructorController extends Controller
{
    public function index()
    {
        $instructores = Instructor::orderBy('id','desc')->paginate(2);
        return view('instructores.index', compact('instructores'));
    }
    public function update(Request $request, $id)
    {
        

        $page = request()->query('page', 1);

        $validator=Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => 'required|digits:8|unique:instructores,dni,'.$id,
            'edad' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('instructores.index',['page'=>$page])
                        ->with('idInstructorEditarFlash',$id)
                        ->withErrors($validator,'frmInstructorModalEditar')
                        ->withInput();
        }
        
        $instructor = Instructor::findOrFail($id);
        
        try{
            $instructor->update([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
                'edad' => $request->edad,
            ]);

            return redirect()->route('instructores.index',['page'=>$page])->with('mensaje', 'Operacion Satisfactoria !!!');

        }catch(QueryException $e){

            LogHelper::logError($this,$e);

            $fechaHoraActual = date("Y-m-d H:i:s");
            $mensaje=$fechaHoraActual.' No se puede actualizar el registro';
            
            return redirect()->route('instructores.index',['page'=>$page])->with('mensaje', $mensaje);
            
        }
    
    }
    public function store(Request $request)
    {
        
        $page = request()->query('page', 1);

        $validator=Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => 'required|digits:8|unique:instructores,dni',
            'edad' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('instructores.index',['page'=>$page])
                        ->withErrors($validator,'frmInstructorModalCrear')
                        ->withInput();
        }
    
        try{
            Instructor::create($request->all());

            return redirect()->route('instructores.index',['page'=>$page])->with('mensaje', 'Operacion Satisfactoria !!!');

        }catch(QueryException $e){

            LogHelper::logError($this,$e);

            $fechaHoraActual = date("Y-m-d H:i:s");
            $mensaje=$fechaHoraActual.' No se puede crear el registro';

            return redirect()->route('instructores.index',['page'=>$page])->with('mensaje', $mensaje);
        }
    }
    public function destroy($id)
    {
        
        $page = request()->query('page', 1);

        try{

            $alumno = Instructor::findOrFail($id);
            $alumno->delete();

            return redirect()->route('instructores.index',['page'=>$page])->with('mensaje', 'Eliminacion satisfactoria !!!');
        
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

            return redirect()->route('instructores.index',['page'=>$page])->with('mensaje', $mensaje);

        }
        
    }
}
