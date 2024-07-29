<!-- Modal de Notificação Geral -->
<div class="modal fade" id="modalNotificacaoGeral" tabindex="-1" aria-labelledby="modalNotificacaoGeralLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNotificacaoGeralLabel">Enviar Notificação Geral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.enviar.notificacao') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="selecionarPara" class="form-label">Selecionar Para</label>
                        <select class="form-select" id="selecionarPara" name="selecionarPara" required>
                            <option value="todos">Todos os Usuários</option>
                            <option value="especifico">Usuário Específico</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="usuarioEspecificoInput">
                        <label for="usuario_id" class="form-label">ID do Usuário Específico</label>
                        <input type="number" class="form-control" id="usuario_id" name="usuario_id">
                    </div>

                    <div class="mb-3 d-none" id="buscaUsuarioInput">
                        <label for="termo" class="form-label">Buscar Usuário por Nome ou Email</label>
                        <input type="text" class="form-control" id="termo" name="termo">
                        <div id="resultadoBusca"></div>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Notificação</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="geral">Notificação Geral (ao entrar/logar)</option>
                            <option value="diaria">Notificação Diária (uma vez por dia)</option>
                            <option value="travamento">Notificação de Travamento</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar Notificação</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Adicione isso dentro da seção de scripts ou arquivo de scripts separado -->
<script>
    $(document).ready(function () {
        // Quando o tipo de seleção é alterado (todos ou específico)
        $('#selecionarPara').change(function () {
            var selecao = $(this).val();

            // Mostrar/esconder campos de busca e ID do usuário específico
            if (selecao === 'especifico') {
                $('#usuarioEspecificoInput').removeClass('d-none');
                $('#buscaUsuarioInput').removeClass('d-none');
                $('#termo').prop('required', true);
                $('#usuario_id').prop('required', false);
            } else {
                $('#usuarioEspecificoInput').addClass('d-none');
                $('#buscaUsuarioInput').addClass('d-none');
                $('#termo').prop('required', false);
                $('#usuario_id').prop('required', false);
            }
        });

        // Quando o campo de busca de usuário é preenchido
        $('#termo').on('input', function () {
            var termo = $(this).val().trim();

            // Verifica se o termo de busca não está vazio
            if (termo.length > 0) {
                // Faz a requisição AJAX para buscar usuários
                $.ajax({
                    url: '{{ route("admin.buscar.usuarios") }}',
                    method: 'GET',
                    data: { termo: termo },
                    success: function (response) {
                        // Limpa o conteúdo anterior
                        $('#resultadoBusca').empty();

                        // Processa a resposta e exibe os resultados
                        if (response.length > 0) {
                            response.forEach(function (usuario) {
                                $('#resultadoBusca').append('<div><input type="radio" name="usuario_escolhido" value="' + usuario.id + '"> ' + usuario.name + ' (' + usuario.email + ')</div>');
                            });
                        } else {
                            $('#resultadoBusca').append('<div>Nenhum usuário encontrado com o termo especificado.</div>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Erro ao buscar usuários:', error);
                    }
                });
            } else {
                $('#resultadoBusca').empty();
            }
        });

        // Quando um usuário é selecionado
        $(document).on('change', 'input[name="usuario_escolhido"]', function () {
            var usuario_id = $(this).val();
            $('#usuario_id').val(usuario_id);
        });
    });
</script>
