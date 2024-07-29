<!-- Modal "Registrar Cliente" -->

<div class="modal fade" id="registerClientModal" tabindex="-1" role="dialog" aria-labelledby="registerClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerClientModalLabel">Registrar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerClientForm" method="POST" action="{{ route('clientes.store') }}">
                    @csrf
                    <div class="row g-3">
                        <!-- Campo: Nome -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                    <!-- Campo: E-mail -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <!-- Campo: Telefone -->
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>

                    <!-- Campo: CPF/CNPJ -->
                    <div class="col-md-6">
                        <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
                        <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" required>
                    </div>

                    <!-- Campo: CEP -->
                    <div class="col-md-4">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" required>
                    </div>

                    <!-- Campo: Estado -->
                    <div class="col-md-4">
                        <label for="state" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="state" name="state" required>
                    </div>

                    <!-- Campo: Cidade -->
                    <div class="col-md-4">
                        <label for="city" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>

                    <!-- Campo: Bairro -->
                    <div class="col-md-6">
                        <label for="neighborhood" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="neighborhood" name="neighborhood" required>
                    </div>

                    <!-- Campo: Rua -->
                    <div class="col-md-4">
                        <label for="street" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="street" name="street" required>
                    </div>

                    <!-- Campo: Número -->
                    <div class="col-md-2">
                        <label for="house_number" class="form-label">Número</label>
                        <input type="text" class="form-control" id="house_number" name="house_number" required>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Registrar Cliente</button>
        </div>
        </form>
    </div>
</div>
</div>
<!-- CSRF Token for AJAX Requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">







<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        $('#registerClientForm').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Verifica se a resposta contém a propriedade 'message'
                    if (response.message) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: response.message,
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        // Se não houver 'message', exibe uma mensagem de erro genérica
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Não foi possível processar sua solicitação.',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Exibe uma mensagem de erro com o status da resposta
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Ocorreu um erro: ' + xhr.status + ' ' + error,
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });
    });


   
</script>