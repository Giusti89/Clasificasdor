<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class TablaUsuarios extends Component
{
    use WithPagination;
    public $usuario;
    public $search;
    public $paginate;

    public function mount()
    {
        $this->paginate = 10;
    }
    
   public function render()
    {
        $paginate = is_numeric($this->paginate) && $this->paginate > 0 ? $this->paginate : 10;
        
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->paginate($paginate);
        
        return view('livewire.tabla-usuarios', compact('users'));
    }
}
