<?php

namespace App\Http\Controllers;

use App\Models\Teconomica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class TeconomicaController extends Controller
{
    public function index()
    {
        return view('administracion.peconomica.index');
    }
    public function create()
    {
        return view('administracion.peconomica.nuevo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'string',
            'presupuesto' => 'required|numeric|between:0,999999.99',
            'codigo' => 'required|numeric|between:0,999999.99',

        ], [
            'nombre.required' => 'El nombre de la partida es obligatorio.',
            'nombre.string' => 'El nombre de la partida debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la partida no debe exceder los 255 caracteres.',


            'descripcion.string' => 'El nombre de la carrera debe ser una cadena de texto.',

            'presupuesto.required' => 'El presupuesto es obligatorio.',
            'presupuesto.numeric' => 'El presupuesto debe ser un número.',
            'presupuesto.between' => 'El presupuesto debe estar entre 0 y 999999.99.',

            'codigo.required' => 'El código es obligatorio.',
            'codigo.numeric' => 'El código debe ser un número.',
            'codigo.between' => 'El código debe estar entre 0 y 999999.99.',
        ]);


        $carrera = new Teconomica();
        $carrera->nombre = $request->input('nombre');
        $carrera->npartida = $request->input('codigo');
        $carrera->presupuesto = $request->input('presupuesto');
        $carrera->descripcion = $request->input('descripcion');


        $carrera->save();
        return redirect()->route('teconomicaCarrera')->with('msj', 'cambio');
    }

    public function edit(string $encryptedId)
    {

        try {
            $id = Crypt::decrypt($encryptedId);
            $teco = Teconomica::find($id);
            return view('administracion.peconomica.edit', compact('teco'));
        } catch (DecryptException $e) {
            return Redirect::route('teconomicaCarrera')->with('msj', 'error');
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|numeric|between:0,999999.99',
            'presupuesto' => 'required|numeric|between:0,999999.99',
            'descripcion' => 'string',
        ], [
            'nombre.required' => 'El nombre de la partida es obligatorio.',
            'nombre.string' => 'El nombre de la partida debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la partida no debe exceder los 255 caracteres.',

            'codigo.required' => 'El código es obligatorio.',
            'codigo.numeric' => 'El código debe ser un número.',
            'codigo.between' => 'El código debe estar entre 0 y 999999.99.',

            'presupuesto.required' => 'El presupuesto es obligatorio.',
            'presupuesto.numeric' => 'El presupuesto debe ser un número.',
            'presupuesto.between' => 'El presupuesto debe estar entre 0 y 999999.99.',

            'descripcion.string' => 'El nombre de la carrera debe ser una cadena de texto.',            
           
        ]);

        $teco = Teconomica::findOrFail($id);

        $teco->nombre = $request->input('nombre');
        $teco->npartida = $request->input('codigo');
        if ($request->agregar) {           
            $teco->presupuesto =  $teco->presupuesto + $request->input('agregar');
        }       
        $teco->descripcion = $request->input('descripcion');

        $teco->save();


        return redirect()->route('teconomicaCarrera')->with('msj', 'cambio');
    }

    public function destroy(string $id)
    {
        try {
            $teco = Teconomica::findOrFail($id);

            $teco->delete();
            return redirect()->route('teconomicaCarrera')->with('msj', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('teconomicaCarrera')->with('success', 'ok');
        }
    }
}
