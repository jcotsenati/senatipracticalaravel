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
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }

        $instructores = Instructor::orderBy('id','desc')->paginate(2);
        return view('instructores.index', compact('instructores'));
    }
    public function update(Request $request, $id)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }

        $page = request()->query('page', 1);

        $validator=Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => 'required|digits:8|unique:instructores,dni,'.$id
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

            $instructor=[
                'id'=>$id,
                'dni'=>$request->dni,
                'nombres'=>$request->nombres,
                'apellidos'=>$request->apellidos
            ];
            $instructor=(object)$instructor;
            
            return redirect()->route('instructores.index',['page'=>$page])->with('mensaje', $mensaje);
            
        }
    
    }
}
