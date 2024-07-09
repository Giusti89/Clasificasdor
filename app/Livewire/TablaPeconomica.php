<?php

namespace App\Livewire;

use App\Models\Teconomica;
use Livewire\Component;
use Livewire\WithPagination;

class TablaPeconomica extends Component
{
    use WithPagination;
    
    public $search;
    public $paginate;

    public function mount()
    {
        $this->paginate = 10;
    }
    public function render()
    {
        $paginate = is_numeric($this->paginate) && $this->paginate > 0 ? $this->paginate : 10;

        $teco = Teconomica::where('npartida', 'like', '%' . $this->search . '%')
            ->paginate($paginate);

        return view('livewire.tabla-peconomica', compact('teco'));
    }
}
