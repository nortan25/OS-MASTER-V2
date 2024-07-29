<!-- Modal para Relatório de Lucro -->
<div id="relatorioLucroModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Acesso ao Relatório de Lucro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="relatorioLucroForm" method="POST" action="{{ route('processar.relatorio.lucro') }}">
                    @csrf
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
                <div id="relatorioLucroMessage" class="mt-2"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#relatorioLucroModal').modal('show');

        $('#relatorioLucroForm').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let data = form.serialize();

            $.post(url, data, function (response) {
                if (response.success) {
                    $('#relatorioLucroMessage').html('<div class="alert alert-success">' + response.success + '</div>');
                    setTimeout(function () {
                        window.location.href = '{{ route('relatorios.lucro-index') }}';
                    }, 1500);
                } else {
                    $('#relatorioLucroMessage').html('<div class="alert alert-danger">' + response.error + '</div>');
                }
            });
        });
    });
</script>
