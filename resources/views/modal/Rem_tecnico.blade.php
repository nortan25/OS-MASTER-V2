<!-- Modal "Remover Técnico" -->
<div class="modal fade" id="modalRemoverTecnico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remover Técnico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário para remover técnico -->
                <form id="formRemoverTecnico" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- Dropdown para selecionar o técnico -->
                    <div class="form-group">
                        <label for="tecnicoDropdown" class="form-label">Selecione o Técnico:</label>
                        <select class="form-control" id="tecnicoDropdown" name="tecnicoDropdown" required>
                            <!-- Opções serão adicionadas dinamicamente via AJAX -->
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecione um técnico.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Botão de remover técnico -->
                <button type="button" class="btn btn-danger" id="btnRemoverTecnico">Remover</button>
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
        // Carregar os nomes dos técnicos no dropdown ao abrir o modal
        $('#modalRemoverTecnico').on('show.bs.modal', function(event) {
            var modal = $(this);
            $.get('tecnicos', function(data) {
                modal.find('#tecnicoDropdown').empty();
                $.each(data, function(key, value) {
                    modal.find('#tecnicoDropdown').append($('<option>', {
                        value: key,
                        text: value
                    }));
                });
            });
        });

        // Evento de clique no botão "Remover Técnico"
        $('#btnRemoverTecnico').on('click', function() {
            // Obter o ID do técnico selecionado no dropdown
            var tecnicoId = $('#tecnicoDropdown').val();

            // Verificar se um técnico foi selecionado
            if (!tecnicoId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Por favor, selecione um técnico.',
                });
                return;
            }

            // Confirmar a remoção do técnico
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Esta ação não pode ser revertida!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, remover!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar a requisição AJAX para remover o técnico
                    $.ajax({
                        url: 'remover-tecnico/' + tecnicoId,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Técnico removido com sucesso.',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Remover o técnico do dropdown após a remoção
                            $('#tecnicoDropdown option[value="' + tecnicoId + '"]').remove();

                            // Fechar o modal após a remoção
                            $('#modalRemoverTecnico').modal('hide');
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: 'Houve um problema ao remover o técnico.',
                            });
                        }
                    });
                }
            });
        });
    });
</script>
