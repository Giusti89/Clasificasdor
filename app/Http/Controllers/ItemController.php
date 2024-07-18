<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Peconomica;
use App\Models\Presupuesto;
use App\Models\Requerimiento;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class ItemController extends Controller
{
    public function index($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $reque = Requerimiento::findOrFail($id);

        $items = Item::where('requerimiento_id', '=', $id)->paginate(5);

        return view('item.index', compact('id', 'items', 'reque'));
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
        $id = Crypt::decrypt($encryptedId);
        $reque = Requerimiento::findOrFail($id);

        $items = Item::where('requerimiento_id', '=', $id)->paginate(5);

        return view('item.vlisto', compact('id', 'items', 'reque'));
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

    public function aprobado($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $reque = Requerimiento::findOrFail($id);

        $items = Item::where('requerimiento_id', '=', $id)->paginate(5);

        return view('item.aprobado', compact('id', 'items', 'reque'));
    }

    public function clasificar($encryptedId)
    {
        $identificador = Crypt::decrypt($encryptedId);
        $encryptedId = Crypt::encrypt($identificador);
        return view('item.clasificar', compact('encryptedId'));
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
        $requeID=$item->requerimiento_id;


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

            return redirect()->route('calsificarReque',Crypt::encrypt($requeID))->with('msj', 'cambio');
        } else {
            return redirect()->route('calsificarReque', Crypt::encrypt($requeID))->with('msj', 'error');
        }
    }
}
