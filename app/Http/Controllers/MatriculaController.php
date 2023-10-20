<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Matricula;
use Illuminate\Database\QueryException;

class MatriculaController extends Controller
{
    public function index(Request $request)
    {
        //if(!session('usuario_autenticado')){
        //    return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        //}

        $dni = $request->input('dni');
        $anioAcad = $request->input('anioAcad');

        if($dni && $anioAcad){

            $alumno = Alumno::where('dni',$dni)->first();
            if(!$alumno){
                return view('matriculas.index',['mensaje'=>'Alumno no encontrado !!!']);
            }

            $matriculas = $alumno->matriculas->where('anioAcad', $anioAcad);
            
            session(['matricula_idAlumno' => $alumno->id]);
            session(['matricula_anioAcad' => $anioAcad]);
            session(['matricula_dni' => $dni]);

            return view('matriculas.index',['alumno'=>$alumno,'matriculas'=>$matriculas,'anioAcad'=>$anioAcad]);
        }
        else{
            return view('matriculas.index');
        }
        
        
    }
    public function search(Request $request)
    {
        //if(!session('usuario_autenticado')){
        //    return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        //}
        
        $dni=$request->input("dni");
        $anioAcad=$request->input("anioAcad");
        
        return redirect()->route('matricula.index',['dni' => $dni,'anioAcad'=>$anioAcad]);
    }
    public function cursoIndex(Request $request)
    {
        //if(!session('usuario_autenticado')){
        //    return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        //}
        
        $codigo = $request->input('codigo');

        if($codigo){

            $curso = Curso::where('codigo',$codigo)->first();
            if(!$curso){
                return view('matriculas.cursoIndex',['mensaje' => 'curso no encontrado!!!']);    
            }
            
            session(['matricula_idCurso' => $curso->id]);

            return view('matriculas.cursoIndex',['curso' => $curso]);
        }
        else{
            return view('matriculas.cursoIndex');
        }
    }
    public function cursoSearch(Request $request)
    {
        //if(!session('usuario_autenticado')){
        //    return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        //}
        
        $codigo=$request->input("codigo");

        return redirect()->route('matricula.curso.index',['codigo' => $codigo]);

    }
    public function cursoMatricular(Request $request)
    {
        //if(!session('usuario_autenticado')){
        //    return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        //}
        
        $idCurso = session('matricula_idCurso');
        $idAlumno = session('matricula_idAlumno');
        $anioAcad = session('matricula_anioAcad');
        $dni = session('matricula_dni');

        $matricula=new Matricula();
        $matricula->idAlumno=$idAlumno;
        $matricula->idCurso=$idCurso;
        $matricula->anioAcad=$anioAcad;
        
        try{

            $matricula->save();

        }catch(QueryException $e){

            return redirect()->route('matricula.index',['dni' => $dni,'anioAcad' => $anioAcad])->with('mensaje', 'Error no se puede crear la matricula !!!');

        }finally {
            session()->forget('matricula_idCurso');
            session()->forget('matricula_idAlumno');
            session()->forget('matricula_anioAcad');
            session()->forget('matricula_dni');
        }
        
        return redirect()->route('matricula.index',['dni' => $dni,'anioAcad' => $anioAcad]);
    }
}
