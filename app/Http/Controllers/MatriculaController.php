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

        $idAlumno = $request->input('idAlumno');
        $anioAcad = $request->input('anioAcad');

        if($idAlumno && $anioAcad){

            $alumno = Alumno::where('id',$idAlumno)->first();
            $matriculas = $alumno->matriculas->where('anioAcad', $anioAcad);
            
            session(['matricula_idAlumno' => $alumno->id]);
            session(['matricula_anioAcad' => $anioAcad]);


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
        $alumno = Alumno::where('dni',$dni)->first();
        
        if($alumno)
            return redirect()->route('matricula.index',['idAlumno' => $alumno->id,'anioAcad'=>$anioAcad]);
        else
            return redirect()->route('matricula.index')->with('mensaje', 'Alumno no encontrado !!!');
    }
    public function cursoIndex(Request $request)
    {
        //if(!session('usuario_autenticado')){
        //    return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        //}
        
        $idCurso = $request->input('idCurso');

        if($idCurso){

            $curso = Curso::where('id',$idCurso)->first();
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
        $curso = Curso::where('codigo',$codigo)->first();
        
        if($curso)
            return redirect()->route('matricula.curso.index',['idCurso' => $curso->id]);
        else
            return redirect()->route('matricula.curso.index')->with('mensaje', 'Curso no encontrado !!!');
    }
    public function cursoMatricular(Request $request)
    {
        //if(!session('usuario_autenticado')){
        //    return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        //}
        
        $idCurso = session('matricula_idCurso');
        $idAlumno = session('matricula_idAlumno');
        $anioAcad = session('matricula_anioAcad');

        $matricula=new Matricula();
        $matricula->idAlumno=$idAlumno;
        $matricula->idCurso=$idCurso;
        $matricula->anioAcad=$anioAcad;
        
        try{

            $matricula->save();

        }catch(QueryException $e){

            return redirect()->route('matricula.index')->with('mensaje', 'Error no se puede crear la matricula !!!');

        }finally {
            session()->forget('matricula_idCurso');
            session()->forget('matricula_idAlumno');
            session()->forget('matricula_anioAcad');
        }
        
        return redirect()->route('matricula.index',['idAlumno' => $idAlumno,'anioAcad' => $anioAcad]);
    }
}
