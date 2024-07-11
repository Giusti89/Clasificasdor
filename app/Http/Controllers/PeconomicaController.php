<?php

namespace App\Http\Controllers;

use App\Models\Peconomica;
use App\Models\Teconomica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PeconomicaController extends Controller
{
    public function create($encryptedId)
    {
        try {

            $id = Crypt::decrypt($encryptedId);

            $sub = Teconomica::find($id);

            $subpartidas = Peconomica::where('teconomica_id', '=', $id)->paginate(3);
            return view('administracion.subeconomicas.index', compact('subpartidas', 'id', 'sub'));
        } catch (DecryptException $e) {

            return redirect()->route('teconomicaCarrera')->with('msj', 'error');
        }
    }

    public function store(Request $request, $Id)
    {


        Peconomica::create([
            'nombre' => $request->nombre,
            'npartida' => $request->codigo,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'teconomica_id' => $Id,
        ]);

        return redirect()->route('subparIndex', Crypt::encrypt($Id))->with('msj', 'cambio');
    }

    public function destroy(string $id)
    {
        try {
            $teco = Peconomica::findOrFail($id);

            $teco->delete();
            return redirect()->route('subparIndex', Crypt::encrypt($id))->with('msj', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('subparIndex',  Crypt::encrypt($id))->with('success', 'ok');
        }
    }

    public function edit(string $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $peco = Peconomica::find($id);
            return view('administracion.subeconomicas.edit', compact('peco'));
        } catch (DecryptException $e) {
            return redirect()->route('teconomicaCarrera')->with('msj', 'error');
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

        $teco = Peconomica::findOrFail($id);

        $teco->nombre = $request->input('nombre');
        $teco->npartida = $request->input('codigo');

        if ($request->agregar) {
            $teco->monto =  $teco->monto + $request->input('agregar');
        }
        $teco->descripcion = $request->input('descripcion');

        $teco->save();


        return redirect()->route('subparIndex', Crypt::encrypt($teco->teconomica_id) )->with('msj', 'cambio');
    }
}
