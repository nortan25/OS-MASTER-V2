<?php

// Em app/Http/Livewire/OrdensSearch.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ordem;

class OrdensSearch extends Component
{
    public $search = '';

    public function render()
    {
        $ordens = Ordem::where('cliente', 'like', '%' . $this->search . '%')->get();

        return view('ordens_servico.', [
            'ordens' => $ordens,
        ]);
    }
}
