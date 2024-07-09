<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Requerimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class RequerimientoController extends Controller
{
    public function create()
    {
        if (!Gate::denies('create', Requerimiento::class)) {
            $user = Auth::user();
            $prueba = $user->carreras->pluck('id', 'nombre');
            $rol = $user->rol->nombre;
    
            return view('docentes.pedidos.index', compact('user', 'rol', 'prueba'));
        }else {
            abort(403, 'No tienes los permisos para realizar la solicitud.');
        }      
    }
    public function store(Request $request)
    {
        $fechaActual = Carbon::now();
    
        if (!Gate::denies('create', Requerimiento::class)) {
          
            Requerimiento::create([
                'descripcion' => $request->descripcion,
                'estado' => 'pendiente',
                'fecha' => $fechaActual,
                'carrera_id' => $request->carrera,
                
            ]);
            return view('docentes.menu.index');
        }else {
           abort(403, 'No tienes los permisos para realizar la solicitud.');
        }
        
    }
    public function edit(string $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $solicitud = Requerimiento::find($id);

            if ($solicitud) {
                $user = Auth::user();
                $prueba = $user->carreras->pluck('id', 'nombre');
                $rol = $user->rol->nombre;

                return view('docentes.pedidos.edit', compact('solicitud', 'prueba', 'rol'));
            } else {
                return Redirect::route('publicoIndex')->with('msj', 'error');
            }
        } catch (\Exception $e) {
            return Redirect::route('publicoIndex')->with('msj', 'error');
        }
    }
    public function update(Request $request, string $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $solicitud = Requerimiento::find($id);

            if ($solicitud) {
                $solicitud->update([
                    'descripcion' => $request->descripcion,
                    'carrera_id' => $request->carrera,
                ]);

                return Redirect::route('publicoIndex')->with('msj', 'Solicitud actualizada exitosamente');
            } else {
                return Redirect::route('publicoIndex')->with('msj', 'Error al actualizar la solicitud');
            }
        } catch (\Exception $e) {
            return Redirect::route('publicoIndex')->with('msj', 'Error al actualizar la solicitud');
        }
    }
    
    public function destroy(string $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $solicitud = Requerimiento::find($id);

            if ($solicitud) {
                $solicitud->delete();
                return Redirect::route('publicoIndex')->with('msj', 'Solicitud eliminada correctamente.');
            } else {
                return Redirect::route('publicoIndex')->with('msj', 'Solicitud no encontrada.');
            }
        } catch (\Exception $e) {
            return Redirect::route('publicoIndex')->with('msj', 'Error al eliminar la solicitud.');
        }
    }
}
