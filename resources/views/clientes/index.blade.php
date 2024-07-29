@extends('layouts.bar')

@section('content')
<div class="container">
    <h1>Clientes</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <input id="searchInput" class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
    <a href="#" data-toggle="modal" data-target="#registerClientModal" class="btn btn-primary">Adicionar Cliente</a>
    <table class="table">
        <thead>
            <tr>
                <th><a href="#" class="sort" data-sort="id">ID</a></th>
                <th><a href="#" class="sort" data-sort="name">Nome</a></th>
                <th><a href="#" class="sort" data-sort="email">Email</a></th>
                <th><a href="#" class="sort" data-sort="phone_number">Telefone</a></th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="clientesTable">
            @foreach ($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone_number }}</td>
                <td>
    <div class="d-flex align-items-center">
        <a href="#" onclick="openEditModal({{ $client->id }})" data-toggle="modal" data-target="#editClientModal" class="btn btn-primary mr-2">Editar</a>
        <button onclick="confirmDelete({{ $client->id }})" class="btn btn-danger">Excluir</button>
    </div>
</td>

                

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection









 <!-- Modal HTML -->
 <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientModalLabel">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editClientForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                               

                                <label for="phone_number">Telefone</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cep">CEP</label>
                                <input type="text" class="form-control" id="cep" name="cep" required>
                            </div>
                        
                        
                            <div class="col-md-6 mb-3">
                                <label for="state">Estado</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city">Cidade</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="neighborhood">Bairro</label>
                                <input type="text" class="form-control" id="neighborhood" name="neighborhood" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="street">Rua</label>
                                <input type="text" class="form-control" id="street" name="street" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="house_number">Número</label>
                                <input type="text" class="form-control" id="house_number" name="house_number" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="submitEditForm()">Salvar mudanças</button>
                </div>
            </div>
        </div>
    </div>
<script>
    function openEditModal(clientId) {
        // Abrir o modal de edição
        $('#editClientModal').modal('show');
    }


    
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function openEditModal(clientId) {
        // Fazer uma requisição AJAX para obter os dados do cliente com o ID fornecido
        $.ajax({
            url: 'clientes/' + clientId,
            type: 'GET',
            success: function(response) {
                // Preencher os campos do formulário com os dados do cliente
                $('#name').val(response.name);
                $('#email').val(response.email);
                $('#phone_number').val(response.phone_number);
                $('#cep').val(response.cep);
                $('#city').val(response.city);
                $('#neighborhood').val(response.neighborhood);
                $('#street').val(response.street);
                $('#house_number').val(response.house_number);
                $('#state').val(response.state);

                // Armazenar o ID do cliente
                $('#editClientForm').data('client-id', clientId);

                // Abrir o modal de edição
                $('#editClientModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição:', error);
            }
        });
    }

    function submitEditForm() {
    // Obter o ID do cliente a partir do formulário
    var clientId = $('#editClientForm').data('client-id');

    // Fazer uma requisição AJAX para atualizar os dados do cliente
    $.ajax({
        url: 'clientes/' + clientId,
        type: 'PUT',
        data: $('#editClientForm').serialize(),
        success: function(response) {
            // Exibir a mensagem de sucesso do servidor
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: response.message || 'Cliente atualizado com sucesso!',
                confirmButtonText: 'Ok',
                onClose: function() {
                    
                }
            });
        },
        error: function(xhr, status, error) {
            // Exibir a mensagem de erro do servidor
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: xhr.responseJSON.message || 'Ocorreu um erro ao atualizar o cliente.',
                confirmButtonText: 'Ok'
            });
        }
    });
}



        $(document).ready(function () {
            var stateMapping = {
                'AC': 'Acre',
                'AL': 'Alagoas',
                'AP': 'Amapá',
                'AM': 'Amazonas',
                'BA': 'Bahia',
                'CE': 'Ceará',
                'DF': 'Federal District',
                'ES': 'Espírito Santo',
                'GO': 'Goiás',
                'MA': 'Maranhão',
                'MT': 'Mato Grosso',
                'MS': 'Mato Grosso do Sul',
                'MG': 'Minas Gerais',
                'PA': 'Pará',
                'PB': 'Paraíba',
                'PR': 'Paraná',
                'PE': 'Pernambuco',
                'PI': 'Piauí',
                'RJ': 'Rio de Janeiro',
                'RN': 'Rio Grande do Norte',
                'RS': 'Rio Grande do Sul',
                'RO': 'Rondônia',
                'RR': 'Roraima',
                'SC': 'Santa Catarina',
                'SP': 'São Paulo',
                'SE': 'Sergipe',
                'TO': 'Tocantins'
            };

            $('#cep').on('input', function () {
                var cep = $(this).val().replace(/\D/g, '');

                if (cep.length != 8) {
                    return;
                }

                $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
                    if (!("erro" in data)) {
                        $('#city').val(data.localidade);
                        $('#neighborhood').val(data.bairro);
                        $('#street').val(data.logradouro);
                        $('#state').val(stateMapping[data.uf]);
                    }
                });
            });
        });
    </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var searchInput = $('#searchInput');
        var orderBy = 'name';
        var orderDirection = 'asc';

        function fetchClients(query = '') {
            $.ajax({
                url: "{{ route('clientes.search') }}",
                type: 'GET',
                data: {
                    query: query,
                    order_by: orderBy,
                    order_direction: orderDirection
                },
                success: function(data) {
                    console.log('Dados recebidos:', data);

                    if (data.data && Array.isArray(data.data)) {
                        var clientesTable = $('#clientesTable');
                        clientesTable.empty();

                        $.each(data.data, function(index, client) {
                            var deleteRoute = "{{ route('clientes.destroy', ':id') }}";
                            deleteRoute = deleteRoute.replace(':id', client.id);

                            // Construindo a linha da tabela com os dados do cliente
                            var row = `
                                <tr>
                                    <td>${client.id}</td>
                                    <td>${client.name}</td>
                                    <td>${client.email}</td>
                                    <td>${client.phone_number}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" onclick="openEditModal(${client.id})" data-toggle="modal" data-target="#editClientModal" class="btn btn-primary mr-2">Editar</a>
                                            <button onclick="confirmDelete(${client.id})" class="btn btn-danger">Excluir</button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            
                            // Adicionando a linha à tabela de clientes
                            clientesTable.append(row);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                }
            });
        }

        // Evento de digitação no campo de busca
        searchInput.on('keyup', function() {
            var query = searchInput.val();
            fetchClients(query);
        });
    });
</script>

<script>
    function confirmDelete(clientId) {
        // Confirmar se o usuário deseja realmente excluir o cliente
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Você está prestes a excluir este cliente. Essa ação não pode ser desfeita.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Se o usuário confirmar a exclusão, enviar uma requisição AJAX para excluir o cliente
                deleteClient(clientId);
            }
        });
    }

    function deleteClient(clientId) {
        // Enviar uma requisição AJAX para excluir o cliente
        $.ajax({
            url: "{{ route('clientes.destroy', ':id') }}".replace(':id', clientId),
            type: 'DELETE',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                // Exibir mensagem de sucesso
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Cliente excluído com sucesso.',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    // Atualizar a página após a exclusão
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            },
            error: function(xhr, status, error) {
                // Exibir mensagem de erro
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ocorreu um erro ao excluir o cliente.',
                    confirmButtonText: 'Ok'
                });
            }
        });
    }
</script>
