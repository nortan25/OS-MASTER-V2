@extends('layouts.bar')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Adicionar Ordem de Serviço</h2>
    <form id="form-ordem" action="{{ route('ordens.store') }}" method="POST">
        @csrf <!-- Diretiva Blade para gerar token CSRF -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <fieldset>
                    <legend>Dados do Cliente</legend>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group position-relative">
                                <label for="cliente">Cliente:</label>
                                <input type="text" id="cliente" class="form-control" placeholder="Pesquisar ou selecionar cliente">
                                <div id="lista-clientes" class="list-group position-absolute w-100" style="display: none; z-index: 1000;"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="phone_number">Telefone:</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cep">CEP:</label>
                                <input type="text" id="cep" name="cep" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" id="endereco-fields" style="display: none;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="state">Estado:</label>
                                <input type="text" id="state" name="state" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="city">Cidade:</label>
                                <input type="text" id="city" name="city" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="street">Rua:</label>
                                <input type="text" id="street" name="street" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="neighborhood">Bairro:</label>
                                <input type="text" id="neighborhood" name="neighborhood" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" id="numero-field" style="display: none;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="house_number">Número:</label>
                                <input type="text" id="house_number" name="house_number" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Detalhes da Ordem de Serviço</legend>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modelo">Modelo do Equipamento:</label>
                                <input type="text" id="modelo" name="modelo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="problema">Problema Relatado:</label>
                                <textarea id="problema" name="problema" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="observacoes">Observação:</label>
                                <textarea id="observacoes" name="observacoes" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Responsáveis</legend>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tecnico">Técnico Responsável:</label>
                                <select id="tecnico" name="tecnico" class="form-control">
                                    <option value="">Selecione o Técnico</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="atendente">Atendente:</label>
                                <select id="atendente" name="atendente" class="form-control">
                                    <option value="">Selecione o Atendente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </form>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        const searchInput = $('#cliente');
        const cidadeInput = $('#city');
        const phone_numberInput = $('#phone_number');
        const cepInput = $('#cep');
        const ruaInput = $('#street');
        const bairroInput = $('#neighborhood');
        const numeroInput = $('#house_number');
        const stateInput = $('#state');
        const clientesList = $('#lista-clientes');

        function debounce(func, delay) {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        }

        function fetchClients(query = '') {
            $.ajax({
                url: "{{ route('buscar_cliente') }}",
                type: 'GET',
                data: { query: query },
                success: function(data) {
                    clientesList.empty().hide();
                    if (data.length > 0) {
                        data.forEach(function(client) {
                            const clienteItem = $('<a></a>')
                                .addClass('list-group-item list-group-item-action cliente-item')
                                .attr('data-id', client.id)
                                .text(client.name)
                                .click(function() {
                                    searchInput.val(client.name);
                                    cidadeInput.val(client.city);
                                    phone_numberInput.val(client.phone_number);
                                    cepInput.val(client.cep);
                                    ruaInput.val(client.street);
                                    bairroInput.val(client.neighborhood);
                                    numeroInput.val(client.house_number);
                                    stateInput.val(client.state);
                                    $('#endereco-fields').show();
                                    $('#numero-field').show();
                                    clientesList.hide();
                                });
                            clientesList.append(clienteItem);
                        });
                        clientesList.show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    alert('Erro ao buscar clientes. Tente novamente.');
                }
            });
        }


        function fetchTecnicos() {
    $.get('get-tecnicos', function(data) {
        const tecnicoSelect = $('#tecnico');
        tecnicoSelect.empty();
        tecnicoSelect.append('<option value="">Selecione o Técnico</option>');
        $.each(data, function(id, name) {
            tecnicoSelect.append($('<option></option>').attr('value', id).text(name));
        });
    }).fail(function(xhr, status, error) {
        console.error('Erro na requisição:', error);
        alert('Erro ao buscar técnicos. Tente novamente.');
    });
}

function fetchAtendentes() {
    $.get('get-atendentes', function(data) {
        const atendenteSelect = $('#atendente');
        atendenteSelect.empty();
        atendenteSelect.append('<option value="">Selecione o Atendente</option>');
        $.each(data, function(id, name) {
            atendenteSelect.append($('<option></option>').attr('value', id).text(name));
        });
    }).fail(function(xhr, status, error) {
        console.error('Erro na requisição:', error);
        alert('Erro ao buscar atendentes. Tente novamente.');
    });
}



        const debouncedFetchClients = debounce(fetchClients, 300);

        searchInput.on('input', function() {
            const clienteNome = $(this).val().trim();
            if (clienteNome.length > 0) {
                debouncedFetchClients(clienteNome);
            } else {
                clientesList.empty().hide();
            }
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#cliente, #lista-clientes').length) {
                clientesList.hide();
            }
        });


        $('form#form-ordem').submit(function() {
            $('<input>').attr({
                type: 'hidden',
                id: 'cliente_hidden',
                name: 'cliente',
                value: $('#cliente').val()
            }).appendTo('form#form-ordem');

            $('<input>').attr({
                type: 'hidden',
                id: 'cidade_hidden',
                name: 'cidade',
                value: $('#city').val()
            }).appendTo('form#form-ordem');

            $('<input>').attr({
                type: 'hidden',
                id: 'state_hidden',
                name: 'state',
                value: $('#state').val()
            }).appendTo('form#form-ordem');

            $('<input>').attr({
                type: 'hidden',
                id: 'phone_number_hidden',
                name: 'phone_number',
                value: $('#phone_number').val()
            }).appendTo('form#form-ordem');

            $('<input>').attr({
                type: 'hidden',
                id: 'cep_hidden',
                name: 'cep',
                value: $('#cep').val()
            }).appendTo('form#form-ordem');

            $('<input>').attr({
                type: 'hidden',
                id: 'rua_hidden',
                name: 'rua',
                value: $('#street').val()
            }).appendTo('form#form-ordem');

            $('<input>').attr({
                type: 'hidden',
                id: 'bairro_hidden',
                name: 'bairro',
                value: $('#neighborhood').val()
            }).appendTo('form#form-ordem');

            $('<input>').attr({
                type: 'hidden',
                id: 'numero_hidden',
                name: 'numero',
                value: $('#house_number').val()
            }).appendTo('form#form-ordem');
            
            return true;
        });
    });
</script>

@endsection