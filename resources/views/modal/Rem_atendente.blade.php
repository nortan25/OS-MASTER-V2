<!-- Modal "Remover Atendente" -->
<div class="modal fade" id="modalRemoverAtendente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remover Atendente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário para remover atendente -->
                <form id="formRemoverAtendente" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- Dropdown para selecionar o atendente -->
                    <div class="form-group">
                        <label for="atendenteDropdown" class="form-label">Selecione o Atendente:</label>
                        <select class="form-control" id="atendenteDropdown" name="atendenteDropdown" required>
                            <!-- Opções serão adicionadas dinamicamente via AJAX -->
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecione um atendente.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Botão de remover atendente -->
                <button type="button" class="btn btn-danger" id="btnRemoverAtendente">Remover</button>
            </div>
        </div>
    </div>
</div>

<!-- CSRF Token for AJAX Requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Script para carregar e remover técnicos -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Carregar os nomes dos atendentes no dropdown
        $.get('atendentes', function(data) {
            $.each(data, function(key, value) {
                $('#atendenteDropdown').append($('<option>', {
                    value: key,
                    text: value
                }));
            });
        });

        // Evento de clique no botão "Remover"
        $('#btnRemoverAtendente').click(function() {
            // Obter o ID do atendente selecionado no dropdown
            var atendenteId = $('#atendenteDropdown').val();

            // Atualizar o action do formulário com o ID selecionado
            $('#formRemoverAtendente').attr('action', 'remover-atendente/' + atendenteId);

            // Submeter o formulário para remover o atendente
            $('#formRemoverAtendente').submit();
        });

        // Manipular a submissão do formulário de remoção de atendente
        $('#formRemoverAtendente').on('submit', function(e) {
            e.preventDefault();

            var actionUrl = $(this).attr('action');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Atendente removido com sucesso.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Houve um problema ao remover o atendente.',
                    });
                }
            });
        });
    });
</script>
