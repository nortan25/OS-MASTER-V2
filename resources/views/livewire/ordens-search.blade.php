{{-- Em resources/views/livewire/ordens-search.blade.php --}}

<div>
    <input wire:model="search" type="text" class="form-control mb-3" placeholder="Digite o nome do cliente...">

    <table class="table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Cidade</th>
                <th>CEP</th>
                <th>Rua</th>
                <th>Bairro</th>
                <th>Modelo</th>
                <th>Problema Relatado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordens as $ordem)
                <tr>
                    <td>{{ $ordem->cliente }}</td>
                    <td>{{ $ordem->cidade }}</td>
                    <td>{{ $ordem->cep }}</td>
                    <td>{{ $ordem->rua }}</td>
                    <td>{{ $ordem->bairro }}</td>
                    <td>{{ $ordem->modelo }}</td>
                    <td>{{ $ordem->problema }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
