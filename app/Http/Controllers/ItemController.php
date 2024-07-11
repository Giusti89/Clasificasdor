<?php

namespace App\Http\Controllers;

use App\Models\Item;
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

        return view('item.listo', compact('id', 'items', 'reque'));
    }
    
    public function listo($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $reque = Requerimiento::findOrFail($id);
            $reque->estado = "listo";
            $reque->update();
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
}
