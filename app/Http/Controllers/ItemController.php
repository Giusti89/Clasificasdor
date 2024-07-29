<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Peconomica;
use App\Models\Presupuesto;
use App\Models\Requerimiento;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\File;

class ItemController extends Controller
{
    public function index($encryptedId)
    {
        try {
            $user = Auth::user();
            $id = Crypt::decrypt($encryptedId);
            $reque = Requerimiento::findOrFail($id);
            $this->authorize('autor', $reque);
            $items = Item::where('requerimiento_id', '=', $id)->paginate(5);
            return view('item.index', compact('id', 'items', 'reque'));
        } catch (\Exception $e) {
            return redirect()->route('publicoIndex')->with(['msj' => 'error']);
        }
    }

    public function store(Request $request, $encryptedId)
    {
        $request->validate([
            'descripcion' => ['required', 'string'],
            'cantidad' => ['required', 'string'],
            'file' => ['nullable', File::image()->max(10 * 1024)],
        ]);

        try {
            $id = Crypt::decrypt($encryptedId);

            $fileName = null;

            if ($request->hasFile('file')) {
                $fileName = time() . '.' . $request->file->extension();
                $request->file->move(public_path('cotizacion'), $fileName);
            }

            Item::create([
                'descripcion' => $request->descripcion,
                'cantidad' => $request->cantidad,
                'image_url' => $fileName,
                'requerimiento_id' => $id,
            ]);

            return redirect()->route('llenarSolicitud', Crypt::encrypt($id))->with('msj', 'cambio');
        } catch (\Throwable $th) {
            return redirect()->route('llenarSolicitud', Crypt::encrypt($id))->with('msj', 'error');
        }
    }

    public function edit(string $encryptedId)
    {
        try {

            $id = Crypt::decrypt($encryptedId);
            $item = Item::find($id);

            return view('item.edit', compact('item', 'encryptedId'));
        } catch (DecryptException $e) {

            return Redirect::route('adminIndex')->with('msj', 'error');
        }
    }

    public function update(Request $request, $encryptedId)
    {
       
        $identificador = Crypt::decrypt($encryptedId);

       
        $request->validate([
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|string|max:255',
            'file' => ['nullable', File::image()->max(10 * 1024)],
        ]);

        
        $item = Item::findOrFail($identificador);

       
        $item->cantidad = $request->input('cantidad');
        $item->descripcion = $request->input('descripcion');

        // Si se sube un archivo, guardarlo y actualizar el campo image_url
        

        if ($request->hasFile('file')) {
            $fileName = time() . '.' . $request->file->extension();
            $filePath = public_path('cotizacion') . '/' . $fileName;
            $request->file->move(public_path('cotizacion'), $fileName);
    
           
            if ($item->image_url) {
                $oldFilePath = public_path('cotizacion') . '/' . $item->image_url;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
    
            $item->image_url = $fileName;           
        }

        // Guardar los cambios
        $item->update();

        // Redirigir con un mensaje de éxito
        return redirect()->route('vistacorreccion', Crypt::encrypt($item->requerimiento_id))
            ->with('success', 'Item actualizado exitosamente.');
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $item = Item::findOrFail($id);
            $item->delete();
            return redirect()->route('llenarSolicitud',  Crypt::encrypt($item->requerimiento_id))->with('msj', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('llenarSolicitud', Crypt::encrypt($item->requerimiento_id))->with('msj', 'error');
        }
    }

    public function vista($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $reque = Requerimiento::findOrFail($id);
            $items = Item::where('requerimiento_id', '=', $id)->paginate(5);

            return view('item.vlisto', compact('id', 'items', 'reque'));
        } catch (\Exception $e) {
            return redirect()->route('publicoIndex')->with('msj', 'error');
        }
    }

    public function listo($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $reque = Requerimiento::findOrFail($id);
            $reque->estado = "listo";
            $reque->save();

            return redirect()->route('publicoIndex')->with('msj', 'cambio');
        } catch (\Throwable $th) {
            return redirect()->route('publicoIndex')->with('msj', 'error');
        }
    }
    public function aprobar($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $reque = Requerimiento::findOrFail($id);
            $reque->estado = "aprobado";
            $reque->update();
            return redirect()->route('publicoIndex')->with('msj', 'cambio');
        } catch (\Throwable $th) {
            return redirect()->route('publicoIndex')->with('msj', 'error');
        }
    }

    public function alta($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $reque = Requerimiento::findOrFail($id);
            $reque->estado = "clasificado";
            $reque->update();
            return redirect()->route('publicoIndex')->with('msj', 'cambio');
        } catch (\Throwable $th) {
            return redirect()->route('publicoIndex')->with('msj', 'error');
        }
    }

    public function aprobado($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $reque = Requerimiento::findOrFail($id);
            $items = Item::where('requerimiento_id', '=', $id)->paginate(5);

            return view('item.aprobado', compact('id', 'items', 'reque'));
        } catch (\Exception $e) {
            Log::error('Error al procesar la aprobación del requerimiento: ' . $e->getMessage());

            return response()->view('errors.500', [], 500);
        }
    }

    public function clasificar($encryptedId)
    {
        try {
            $identificador = Crypt::decrypt($encryptedId);
            $encryptedId = Crypt::encrypt($identificador);
            return view('item.clasificar', compact('encryptedId'));
        } catch (\Exception $e) {
            Log::error('Error al procesar la clasificación del item: ' . $e->getMessage());

            return response()->view('errors.500', [], 500);
        }
    }
    public function ejecutar(Request $request)
    {

        $request->validate([
            'subpartida_id' => 'required',
            'precio' => 'required|numeric',
        ]);

        $itemId = Crypt::decrypt($request->input('item_id'));
        $item = Item::findOrFail($itemId);
        $subPartida = Peconomica::findOrFail($request->input('subpartida_id'));


        $montoPart = $subPartida->monto;
        $cantidad = $item->cantidad;
        $requeID = $item->requerimiento_id;


        $carreraId = $item->requerimiento->carrera_id;

        $presupuesto = Presupuesto::where('carrera_id', $carreraId)->first();

        if ($presupuesto->monto > $request->input('precio') && $montoPart > $request->input('precio')) {
            $presupuesto->monto -= $request->input('precio');

            $item->peconomica_id = $request->input('subpartida_id');
            $item->costo = $request->input('precio');

            $item->punitario = $request->input('precio') / $cantidad;
            $subPartida->monto  -= $request->input('precio');

            $presupuesto->save();
            $item->save();
            $subPartida->save();

            return redirect()->route('calsificarReque', Crypt::encrypt($requeID))->with('msj', 'cambio');
        } else {
            return redirect()->route('calsificarReque', Crypt::encrypt($requeID))->with('msj', 'error');
        }
    }
    public function vobservacion($encryptedId)
    {
        $identificador = Crypt::decrypt($encryptedId);
        $item = Requerimiento::findOrFail($identificador);

        return view('item.observacion', compact('identificador', 'item', 'encryptedId'));
    }
    public function storeObservacion(Request $request, $encryptedId)
    {
        // Desencriptar el ID
        $identificador = Crypt::decrypt($encryptedId);

        // Validar la solicitud
        $request->validate([
            'observacion' => 'required|string|max:255',
        ]);

        // Encontrar el requerimiento por ID
        $requerimiento = Requerimiento::findOrFail($identificador);

        // Actualizar el campo observacion y estado
        $requerimiento->observaciones = $request->input('observacion');
        $requerimiento->estado = 'observado'; // Asignar el estado observado
        $requerimiento->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('publicoIndex')->with('msj', 'cambio');
    }

    public function vcorreccion($encryptedId)
    {
        try {
            $user = Auth::user();
            $id = Crypt::decrypt($encryptedId);
            $reque = Requerimiento::findOrFail($id);
            $this->authorize('autor', $reque);
            $items = Item::where('requerimiento_id', '=', $id)->paginate(5);
            return view('item.correccion', compact('id', 'items', 'reque'));
        } catch (\Exception $e) {
            return redirect()->route('publicoIndex')->with(['msj' => 'error']);
        }
    }
}
