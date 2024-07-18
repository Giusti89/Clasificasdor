<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Peconomica;
use App\Models\Teconomica;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class TablaClasificador extends Component
{
    public $partidas;
    public $subpartida;
    public $subpartidas=[];
    public $identificador;
    public $partidaId;
    public $subpartidaId;  
    public $idItem;  

    public function mount($identificador)
    {
        $id = Crypt::decrypt($identificador);
        $teco = Item::find($id);
     
        $this->identificador = Crypt::encrypt($teco->requerimiento_id);
        $this->idItem=Crypt::encrypt($teco->id);
        
        $this->partidas = Teconomica::all();
        $this->subpartidas =collect();
    }
    public function updatedPartidaId($value)
    {
        $this->subpartidas =Peconomica::where('teconomica_id',$value)->get();
        $this->subpartida=$this->subpartidas->first()->id ?? null;
    }

    public function render()
    {
        return view('livewire.tabla-clasificador');
    }
}
