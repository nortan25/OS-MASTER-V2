<div class="modal fade" id="modalCriarGarantia" tabindex="-1" role="dialog" aria-labelledby="modalCriarGarantiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCriarGarantiaLabel">Criar Garantia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-garantia" action="{{ route('garantias.store') }}" method="POST">
                @csrf <!-- Diretiva Blade para gerar token CSRF -->
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Dados do Cliente -->
                        <div class="col-md-6">
                            <fieldset>
                                <legend>Dados do Cliente</legend>
                                <div class="form-group">
                                    <label for="clienteGarantia" class="form-label">Buscar Cliente:</label>
                                    <input type="text" id="clienteGarantia" name="clienteGarantia" class="form-control" placeholder="Digite o nome do cliente" required>
                                    <div id="lista-clientes-garantia" class="list-group mt-2" style="position: absolute; z-index: 1000; width: 100%; display: none;"></div>
                                </div>
                                <div id="dados-cliente-garantia" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone_numberGarantia" class="form-label">Telefone:</label>
                                                <input type="text" id="phone_numberGarantia" name="phone_numberGarantia" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cepGarantia" class="form-label">CEP:</label>
                                                <input type="text" id="cepGarantia" name="cepGarantia" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="ruaGarantia" class="form-label">Rua:</label>
                                                <input type="text" id="ruaGarantia" name="ruaGarantia" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="bairroGarantia" class="form-label">Bairro:</label>
                                                <input type="text" id="bairroGarantia" name="bairroGarantia" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="stateGarantia" class="form-label">Estado:</label>
                                                <input type="text" id="stateGarantia" name="stateGarantia" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cidadeGarantia" class="form-label">Cidade:</label>
                                                <input type="text" id="cidadeGarantia" name="cidadeGarantia" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="numeroGarantia" class="form-label">Número:</label>
                                                <input type="text" id="numeroGarantia" name="numeroGarantia" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <!-- Dados da Garantia -->
                        <div class="col-md-6">
                            <fieldset>
                                <legend>Dados da Garantia</legend>
                                <div class="form-group">
                                    <label for="tipoGarantia" class="form-label">Tipo de Garantia:</label>
                                    <select id="tipoGarantia" name="tipoGarantia" class="form-control" required>
                                        <option value="">Selecione o Tipo</option>
                                        <option value="produto">Produto</option>
                                        <option value="servico">Serviço</option>
                                    </select>
                                </div>
                                <div class="form-group" id="camposProduto" style="display: none;">
                                    <label for="nomeProduto" class="form-label">Nome do Produto:</label>
                                    <input type="text" id="nomeProduto" name="nomeProduto" class="form-control">
                                    <label for="tempoGarantiaProduto" class="form-label mt-2">Tempo de Garantia (em dias):</label>
                                    <input type="number" id="tempoGarantiaProduto" name="tempoGarantiaProduto" class="form-control">
                                </div>
                                <div class="form-group" id="camposServico" style="display: none;">
                                    <label for="servicoRealizado" class="form-label">Serviço Realizado:</label>
                                    <input type="text" id="servicoRealizado" name="servicoRealizado" class="form-control">
                                    <label for="modeloAparelho" class="form-label mt-2">Modelo do Aparelho:</label>
                                    <input type="text" id="modeloAparelho" name="modeloAparelho" class="form-control">
                                    <label for="tempoGarantiaServico" class="form-label mt-2">Tempo de Garantia (em dias):</label>
                                    <input type="number" id="tempoGarantiaServico" name="tempoGarantiaServico" class="form-control">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="observacoes" class="form-label">Observações:</label>
                                    <textarea id="observacoesGarantia" name="observacoes" class="form-control" rows="4"></textarea>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Função para buscar clientes e preencher automaticamente os campos
        function fetchClients(query = '') {
            $.ajax({
                url: "{{ route('buscar_cliente') }}",
                type: 'GET',
                data: { query: query },
                success: function(data) {
                    const clientesList = $('#lista-clientes-garantia');
                    const dadosCliente = $('#dados-cliente-garantia');

                    clientesList.empty().hide();

                    if (data.length > 0) {
                        data.forEach(function(client) {
                            const clienteItem = $('<a></a>')
                                .addClass('list-group-item list-group-item-action cliente-item')
                                .attr('data-id', client.id)
                                .text(client.name)
                                .click(function() {
                                    // Preenche os campos com os dados do cliente selecionado
                                    $('#clienteGarantia').val(client.name);
                                    $('#cidadeGarantia').val(client.city);
                                    $('#phone_numberGarantia').val(client.phone_number);
                                    $('#cepGarantia').val(client.cep);
                                    $('#ruaGarantia').val(client.street);
                                    $('#bairroGarantia').val(client.neighborhood);
                                    $('#numeroGarantia').val(client.house_number);
                                    $('#stateGarantia').val(client.state);

                                    // Mostra os dados do cliente e esconde a lista de clientes
                                    dadosCliente.show();
                                    clientesList.hide();
                                });

                            clientesList.append(clienteItem);
                        });

                        // Mostra a lista de clientes
                        clientesList.show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    alert('Erro ao buscar clientes. Tente novamente.');
                }
            });
        }

        // Debounce para limitar a frequência das requisições AJAX
        function debounce(func, delay) {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        }

        // Captura todos os dados preenchidos no formulário
        function captureFormData() {
            const formData = {
                _token: "{{ csrf_token() }}", // Adiciona o token CSRF para proteção
                tipoGarantia: $('#tipoGarantia').val(),
                nomeProduto: $('#nomeProduto').val(),
                tempoGarantiaProduto: $('#tempoGarantiaProduto').val(),
                servicoRealizado: $('#servicoRealizado').val(),
                modeloAparelho: $('#modeloAparelho').val(),
                tempoGarantiaServico: $('#tempoGarantiaServico').val(),
                observacoes: $('#observacoesGarantia').val(),
                // Captura os campos preenchidos automaticamente
                name: $('#clienteGarantia').val(),
                city: $('#cidadeGarantia').val(),
                phone_number: $('#phone_numberGarantia').val(),
                cep: $('#cepGarantia').val(),
                street: $('#ruaGarantia').val(),
                neighborhood: $('#bairroGarantia').val(),
                house_number: $('#numeroGarantia').val(),
                state: $('#stateGarantia').val()
            }; 
            
            console.log(formData); // Verificar se o campo "observacoes" está sendo capturado corretamente
            return formData;
        }

        // Evento de input no campo de busca de cliente
        $('#clienteGarantia').on('input', debounce(function() {
            const query = $(this).val().trim();
            fetchClients(query);
        }, 300));

        // Evento de mudança no tipo de garantia
        $('#tipoGarantia').change(function() {
            const tipoGarantia = $(this).val();
            if (tipoGarantia === 'produto') {
                $('#camposProduto').show();
                $('#camposServico').hide();
            } else if (tipoGarantia === 'servico') {
                $('#camposProduto').hide();
                $('#camposServico').show();
            } else {
                $('#camposProduto').hide();
                $('#camposServico').hide();
            }
        });

        // Manipulação do formulário de garantia
        $('#form-garantia').submit(function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            // Remove o atributo readonly antes de enviar os dados
            $('#cidadeGarantia').removeAttr('readonly');
            $('#phone_numberGarantia').removeAttr('readonly');
            $('#cepGarantia').removeAttr('readonly');
            $('#ruaGarantia').removeAttr('readonly');
            $('#bairroGarantia').removeAttr('readonly');
            $('#numeroGarantia').removeAttr('readonly');
            $('#stateGarantia').removeAttr('readonly');

            // Coleta dos dados do formulário
            const dataToSend = captureFormData();

            // Realiza a requisição AJAX para enviar os dados
            $.ajax({
                url: "{{ route('garantias.store') }}", // Mantém a rota para salvar garantias
                type: 'POST',
                data: dataToSend,
                success: function(response) {
                    window.location.href = "{{ route('gerar_pdf_ultima_garantia') }}"; // Redireciona após o salvamento
                    $('#modalCriarGarantia').modal('hide');
                    // Limpar os campos do formulário para a próxima entrada
                    $('#form-garantia')[0].reset();
                },
                error: function(xhr, status, error) {
                    // Manipula o erro da requisição
                    console.error('Erro ao salvar garantia:', error);
                    alert('Erro ao salvar garantia. Tente novamente.');
                },
                complete: function() {
                    // Adiciona o atributo readonly novamente após o envio
                    $('#cidadeGarantia').attr('readonly', true);
                    $('#phone_numberGarantia').attr('readonly', true);
                    $('#cepGarantia').attr('readonly', true);
                    $('#ruaGarantia').attr('readonly', true);
                    $('#bairroGarantia').attr('readonly', true);
                    $('#numeroGarantia').attr('readonly', true);
                    $('#stateGarantia').attr('readonly', true);
                }
            });
        });
    });
</script>
