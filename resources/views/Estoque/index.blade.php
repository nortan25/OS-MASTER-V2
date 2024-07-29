@extends('layouts.bar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Lista de Estoque</div>

                <div class="card-body">
                    <!-- Formulário de Filtro -->
                    <form action="{{ route('estoque.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="searchByName">Buscar por Nome:</label>
                                    <input type="text" class="form-control" id="searchByName" name="name" value="{{ request()->input('name') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="searchByTag">Filtrar por Tag:</label>
                                    <select class="form-control" id="searchByTag" name="tag">
                                        <option value="">Selecionar Tag...</option>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag }}" {{ request()->input('tag') == $tag ? 'selected' : '' }}>{{ $tag }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="searchBySKU">Buscar por Código SKU:</label>
                                    <input type="text" class="form-control" id="searchBySKU" name="sku" value="{{ request()->input('sku') }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>

                    <!-- Tabela de Estoque -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome do Produto</th>
                                    <th>Tag do Produto</th>
                                    <th>Valor</th>
                                    <th>Código SKU</th>
                                    <th>Quantidade</th>
                                    <th>Descrição</th>
                                    <th>Ações</th> <!-- Nova coluna para as ações -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estoque as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nome_produto }}</td>
                                    <td>{{ $item->tag_produto }}</td>
                                    <td>{{ $item->valor_produto }}</td>
                                    <td>{{ $item->codigo_sku }}</td>
                                    <td>{{ $item->quantidade }}</td>
                                    <td>{{ $item->descricao }}</td>
                                    <td>
                                        <!-- Botões de Ação -->
                                        <div class="btn-group" role="group" aria-label="Ações">
                                            <button type="button" class="btn btn-sm btn-secondary btn-editar-produto" data-bs-toggle="modal" data-bs-target="#modalEditarProduto{{ $item->id }}">Editar Produto</button>
                                            <button type="button" class="btn btn-sm btn-danger btn-excluir" data-id="{{ $item->id }}">Excluir</button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal de Edição de Produto -->
                             
<div class="modal fade" id="modalEditarProduto{{ $item->id }}" tabindex="-1" aria-labelledby="modalEditarProdutoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarProdutoLabel">Editar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarProduto{{ $item->id }}" data-id="{{ $item->id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nome_produto{{ $item->id }}" class="form-label">Nome do Produto:</label>
                                <input type="text" class="form-control" id="nome_produto{{ $item->id }}" name="nome_produto" value="{{ $item->nome_produto }}">
                            </div>
                            <div class="mb-3">
                                <label for="tag_produto{{ $item->id }}" class="form-label">Tag do Produto:</label>
                                <input type="text" class="form-control" id="tag_produto{{ $item->id }}" name="tag_produto" value="{{ $item->tag_produto }}">
                            </div>
                            <div class="mb-3">
                                <label for="valor_produto{{ $item->id }}" class="form-label">Valor do Produto:</label>
                                <input type="text" class="form-control" id="valor_produto{{ $item->id }}" name="valor_produto" value="{{ $item->valor_produto }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="codigo_sku{{ $item->id }}" class="form-label">Código SKU:</label>
                                <input type="text" class="form-control" id="codigo_sku{{ $item->id }}" name="codigo_sku" value="{{ $item->codigo_sku }}">
                            </div>
                            <div class="mb-3">
                                <label for="quantidade{{ $item->id }}" class="form-label">Quantidade:</label>
                                <input type="number" class="form-control" id="quantidade{{ $item->id }}" name="quantidade" value="{{ $item->quantidade }}">
                            </div>
                            <div class="mb-3">
                                <label for="descricao{{ $item->id }}" class="form-label">Descrição:</label>
                                <textarea class="form-control" id="descricao{{ $item->id }}" name="descricao">{{ $item->descricao }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-salvar-produto" data-id="{{ $item->id }}">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Função para preencher modal com dados atuais
        $('.btn-editar-produto').click(function() {
            var itemId = $(this).data('id');
            var item = {
                nome_produto: $('#nome_produto' + itemId).val(),
                tag_produto: $('#tag_produto' + itemId).val(),
                valor_produto: $('#valor_produto' + itemId).val(),
                codigo_sku: $('#codigo_sku' + itemId).val(),
                quantidade: $('#quantidade' + itemId).val(),
                descricao: $('#descricao' + itemId).val()
            };
            // Preencher campos do modal com os valores atuais
            $('#nome_produto' + itemId).val(item.nome_produto);
            $('#tag_produto' + itemId).val(item.tag_produto);
            $('#valor_produto' + itemId).val(item.valor_produto);
            $('#codigo_sku' + itemId).val(item.codigo_sku);
            $('#quantidade' + itemId).val(item.quantidade);
            $('#descricao' + itemId).val(item.descricao);
        });

        // Função para salvar produto editado via AJAX
        $('.btn-salvar-produto').click(function() {
            var itemId = $(this).data('id');
            var nomeProduto = $('#nome_produto' + itemId).val();
            var tagProduto = $('#tag_produto' + itemId).val();
            var valorProduto = $('#valor_produto' + itemId).val();
            var codigoSKU = $('#codigo_sku' + itemId).val();
            var quantidade = $('#quantidade' + itemId).val();
            var descricao = $('#descricao' + itemId).val();

            // AJAX para enviar dados do produto para o servidor
            $.ajax({
                type: 'PUT', // Método HTTP PUT para atualização
                url: 'estoque/' + itemId, // URL para atualizar o produto
                data: {
                    _token: '{{ csrf_token() }}',
                    nome_produto: nomeProduto,
                    tag_produto: tagProduto,
                    valor_produto: valorProduto,
                    codigo_sku: codigoSKU,
                    quantidade: quantidade,
                    descricao: descricao
                },
                success: function(response) {
                    $('#modalEditarProduto' + itemId).modal('hide'); // Fechar modal após salvar
                    alert('Produto atualizado com sucesso!');
                    // Atualizar a tabela ou outras ações necessárias
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao atualizar produto:', error);
                    alert('Erro ao atualizar produto. Verifique o console para mais detalhes.');
                }
            });
        });

        // Função para excluir produto via AJAX
        $('.btn-excluir').click(function() {
            var itemId = $(this).data('id');

            // AJAX para enviar requisição de exclusão para o servidor
            $.ajax({
                type: 'DELETE',
                url: 'delete/' + itemId, // URL para excluir o produto
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Remover item da tabela ou outras ações necessárias
                    alert('Item excluído com sucesso!');
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao excluir item:', error);
                    alert('Erro ao excluir item. Verifique o console para mais detalhes.');
                }
            });
        });
    });
</script>
