<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Curso;
use Illuminate\Database\QueryException;

class CursoController extends Controller
{
    public function index()
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }
        
        $cursos = Curso::orderBy('id','desc')->paginate(3);
        return view('cursos.index', compact('cursos'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'ciclo' => 'required',
        ]);

        try{

            Curso::create($request->all());

            return response()->json(['message' => 'Operacion Satisfactoria'],200);

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

            return response()->json(['message' => $mensaje],422);
        }
    }
}
