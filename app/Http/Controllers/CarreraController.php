<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Presupuesto;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Models\CarreraUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CarreraController extends Controller
{
    public function index()
    {
        return view('administracion.carreras.index');
    }

    public function create()
    {
        return view('administracion.carreras.nuevo');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'monto' => 'required|numeric|between:0,999999.99',
        ], [
            'nombre.required' => 'El nombre de la carrera es obligatorio.',
            'nombre.string' => 'El nombre de la carrera debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la carrera no debe exceder los 255 caracteres.',

            'monto.required' => 'El presupuesto es obligatorio.',
            'monto.numeric' => 'El presupuesto debe ser un número.',
            'monto.between' => 'El presupuesto debe estar entre 0 y 999999.99.',
        ]);

        // Crear la carrera
        $carrera = Carrera::create([
            'nombre' => $request->nombre,
        ]);

        // Crear el presupuesto para la carrera
        $presupuesto = Presupuesto::create([
            'carrera_id' => $carrera->id,
            'monto' => $request->monto,
        ]);

        return redirect()->route('adminCarrera')->with('msj', 'cambio');
    }

    public function asignar($id)
    {
        $carrera = Carrera::findOrFail($id);

        // Obtener todos los usuarios que no son 'Dir Administrativo'
        $usuariosDisponibles = User::where('rol_id', '!=', 1)->pluck('name', 'id');

        // Obtener los usuarios que ya están asignados a esta carrera
        $usuariosAsignados = $carrera->users()->where('rol_id', '!=', 1)->paginate(4);

        return view('administracion.carreras.asignar', compact('carrera', 'usuariosDisponibles', 'usuariosAsignados'));
    }

    public function asignarUsuarioCarrera(Request $request, $carreraId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $carrera = Carrera::findOrFail($carreraId);
        $carrera->users()->attach($request->user_id);

        return redirect()->route('asigCarr', $carreraId)->with('msj', 'cambio');
    }

    public function eliminarUsuarioCarrera($carreraId, $userId)
    {
        $carrera = Carrera::findOrFail($carreraId);
        $carrera->users()->detach($userId);

        return redirect()->route('asigCarr', $carreraId)->with('msj', 'ok');
    }

    public function destroy($id)
    {
        DB::beginTransaction(); // Iniciar la transacción

        try {
            // Obtener la carrera
            $carrera = Carrera::findOrFail($id);

            // Verificar si hay usuarios asignados a esta carrera
            if ($carrera->users()->exists()) {
                return redirect()->route('adminCarrera')->with(['msj' => 'error']);
            }

            // Eliminar presupuestos relacionados
            $carrera->presupuestos()->delete();

            // Eliminar la carrera
            $carrera->delete();

            DB::commit(); // Confirmar la transacción

            return redirect()->route('adminCarrera')->with('msj', 'ok');
        } catch (Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error
            return redirect()->route('adminCarrera')->with(['msj' => 'prohibido']);
        }
    }
    public function edit(string $id)
    {
        $datos = Carrera::select('carreras.id', 'carreras.nombre', 'presupuestos.monto as presupuesto')
            ->join('presupuestos', 'presupuestos.carrera_id', '=', 'carreras.id')
            ->where('carreras.id', $id)
            ->first();

        $carreras = Carrera::join('presupuestos', 'presupuestos.carrera_id', '=', 'carreras.id')
            ->select('carreras.id', 'carreras.nombre', 'presupuestos.monto')
            ->where('carreras.id', '!=', $id)
            ->get();

        if ($datos) {

            return view('administracion.carreras.edit', compact('datos', 'carreras'));
        } else {
            return Redirect::route('adminIndex')->with('msj', 'error');
        }
    }
    public function update(Request $request, $id)
    {

        dd($request);

    }
}
