<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <!-- Adicionando o favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Master Os') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Master Os
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <!-- Adicione aqui os botões da barra esquerda, se necessário -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto"> <!-- Alteração aqui para ml-auto -->
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                           

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                            </li>



 <!-- Dropdown Caixa -->
               <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="caixaDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Caixa
                    </a>
                    <div class="dropdown-menu" aria-labelledby="caixaDropdown">
                    <a class="dropdown-item" href="{{ route('caixa.iniciar') }}">Iniciar Caixa</a>

                        <a class="dropdown-item" href="{{ route('historico.caixa') }}">Historico de caixa </a>
                    </div>
                </li>
                <!-- Dropdown Estoque -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="estoqueDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Estoque
                    </a>
                    <div class="dropdown-menu" aria-labelledby="estoqueDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#registerStockModal">Registrar Estoque</a>
                        <a class="dropdown-item" href="{{ route('estoque.index') }}">Ver Estoque</a>
                    </div>
                </li>
            




                           <!-- Novo botão "Funcionários" com o dropdown -->
<li class="nav-item dropdown">
    <a id="navbarDropdownFuncionarios" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('Funcionários') }}
    </a>
    <!-- Dropdown interno para Funcionários -->
    <div class="dropdown-menu" aria-labelledby="navbarDropdownFuncionarios">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalRegistrarAtendente">{{ __('Adicionar Atendente') }}</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalAdicionarTecnico">{{ __('Adicionar Técnico') }}</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalRemoverAtendente">{{ __('Remover Atendente') }}</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalRemoverTecnico">{{ __('Remover Técnico') }}</a>
    </div>
</li>

<!-- Novo botão "Garantia" com o dropdown -->
<li class="nav-item dropdown">
    <a id="navbarDropdownGarantia" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('Garantia') }}
    </a>
    <!-- Dropdown interno para Garantias -->
    <div class="dropdown-menu" aria-labelledby="navbarDropdownGarantia">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalCriarGarantia">{{ __('Criar Garantia') }}</a>
        <a class="dropdown-item" href="{{ route('historico_garantias') }}">{{ __('Histórico de Garantias') }}</a>
    </div>
</li>












<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="clientesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Clientes
    </a>
    <div class="dropdown-menu" aria-labelledby="clientesDropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#registerClientModal">Registrar cliente</a>
        <a class="dropdown-item" href="{{ route('clientes.index') }}">Clientes</a>
    </div>
</li>






                            <li class="nav-item dropdown">
    <a id="navbarDropdownOrdem" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('Histórico de Ordem') }}
    </a>
    <!-- Dropdown interno para Histórico de Ordem -->
    <div class="dropdown-menu" aria-labelledby="navbarDropdownOrdem">
        <a class="dropdown-item" href="{{ route('ordens.index') }}">{{ __('Lista de Ordens') }}</a>
        <a class="dropdown-item" href="{{ route('orcamentos.index') }}">{{ __('Lista de Orcamento') }}</a>
    </div>
</li>
                            
<li class="nav-item dropdown">
    <a id="navbarDropdownOrdem" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('Ordem') }}
    </a>
    <!-- Dropdown interno para Garantias -->
    <div class="dropdown-menu" aria-labelledby="navbarDropdownOrdem">
    <a class="dropdown-item" href="{{ route('adicionar_orcamento') }}">{{ __('Criar Orçamento') }}</a>
        <a class="dropdown-item" href="{{ route('adicionar_ordem') }}">{{ __('Criar Ordem') }}</a>
    </div>
</li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- Botão "Ajustes" que inicia uma rota de ajustes -->
                                    <a class="dropdown-item" href="{{ route('ajustes') }}">
                                        {{ __('Ajustes') }}
                                    </a>
                                    <!-- Botão "Logout" existente -->
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li> 
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>











<!-- Modal de Registro de Estoque -->
<div class="modal fade" id="registerStockModal" tabindex="-1" role="dialog" aria-labelledby="registerStockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerStockModalLabel">Registrar Estoque</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulário de Registro de Estoque -->
                <form id="registerStockForm">
                    <!-- Campo: Nome do Produto -->
                    <div class="form-group">
                        <label for="productName">Nome do Produto:</label>
                        <input type="text" class="form-control" id="productName" name="productName" placeholder="Digite o nome do produto" required>
                    </div>

                    <!-- Campo: Tag do Produto -->
                    <div class="form-group">
                        <label for="productTag">Tag do Produto:</label>
                        <input type="text" class="form-control" id="productTag" name="productTag" placeholder="Digite a tag do produto">
                    </div>

                    <!-- Campo: Valor do Produto -->
                    <div class="form-group">
                        <label for="productValue">Valor do Produto:</label>
                        <input type="number" step="0.01" class="form-control" id="productValue" name="productValue" placeholder="Digite o valor do produto" required>
                    </div>

                    <!-- Campo: Código SKU do Produto -->
                    <div class="form-group">
                        <label for="productSKU">Código SKU do Produto:</label>
                        <input type="text" class="form-control" id="productSKU" name="productSKU" placeholder="Digite o código SKU do produto">
                    </div>

                    <!-- Campo: Quantidade do Produto -->
                    <div class="form-group">
                        <label for="productQuantity">Quantidade do Produto:</label>
                        <input type="number" class="form-control" id="productQuantity" name="productQuantity" placeholder="Digite a quantidade do produto" required>
                    </div>

                    <!-- Campo: Descrição do Produto -->
                    <div class="form-group">
                        <label for="productDescription">Descrição do Produto:</label>
                        <textarea class="form-control" id="productDescription" name="productDescription" rows="3" placeholder="Digite uma descrição do produto"></textarea>
                    </div>

                    <!-- Botão de Submit -->
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#registerStockForm').submit(function(event) {
            event.preventDefault();

            var productName = $('#productName').val();
            var productTag = $('#productTag').val();
            var productValue = $('#productValue').val();
            var productSKU = $('#productSKU').val();
            var productQuantity = $('#productQuantity').val();
            var productDescription = $('#productDescription').val();

            // Console log para verificar os dados recuperados
            console.log('Nome do Produto:', productName);
            console.log('Tag do Produto:', productTag);
            console.log('Valor do Produto:', productValue);
            console.log('Código SKU do Produto:', productSKU);
            console.log('Quantidade do Produto:', productQuantity);
            console.log('Descrição do Produto:', productDescription);

            // Dados a serem enviados
            var formData = {
                user_id: 1, // Aqui você deve definir o user_id conforme a lógica da sua aplicação
                nome_produto: productName,
                tag_produto: productTag,
                valor_produto: productValue,
                codigo_sku: productSKU,
                quantidade: productQuantity,
                descricao: productDescription
            };

            // Requisição AJAX
            $.ajax({
                type: 'POST',
                url: "{{ route('estoque.create') }}", // Defina sua rota adequada aqui
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                encode: true,
                success: function(data) {
                    // Limpar campos do formulário após o sucesso
                    $('#productName').val('');
                    $('#productTag').val('');
                    $('#productValue').val('');
                    $('#productSKU').val('');
                    $('#productQuantity').val('');
                    $('#productDescription').val('');

                    // Fechar o modal após o sucesso
                    $('#registerStockModal').modal('hide');

                    // Feedback para o usuário
                    alert('Produto registrado com sucesso!');
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao registrar o produto:', error);
                    alert('Erro ao registrar o produto. Verifique o console para mais detalhes.');
                }
            });
        });
    });
</script>



            













 



























   
        
      
                   

    



<!-- Modal "Registrar Atendente" -->
<div class="modal fade" id="modalRegistrarAtendente"  tabindex="-1" aria-labelledby="modalRegistrarAtendenteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarAtendenteLabel">Registrar Atendenteo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulário para adicionar atendente  -->
                <form id="formRegistrarAtendente" method="POST">
                    @csrf
                    <!-- Campo de nome do atendente -->
                    <div class="form-group">
                    <label for="nomeAtendente">Nome do Atendente:</label>
                    <input type="text" class="form-control" id="nomeAtendente" name="nomeAtendente" placeholder="Digite o nome do atendente" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <!-- Botão de adicionar técnico -->
                <button type="button" id="btnRegistrarAtendente" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>








<!-- Modal "Adicionar Técnico" -->
<div class="modal fade" id="modalAdicionarTecnico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Técnico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulário para adicionar técnico -->
                <form id="formAdicionarTecnico" method="POST">
                    @csrf
                    <!-- Campo de nome do técnico -->
                    <div class="form-group">
                        <label for="nomeTecnico">Nome:</label>
                        <input type="text" class="form-control" id="nomeTecnico" name="nomeTecnico" placeholder="Digite o nome do técnico" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <!-- Botão de adicionar técnico -->
                <button type="button" class="btn btn-primary" id="btnAdicionarTecnico">Adicionar</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal "Remover Atendente" -->
<div class="modal fade" id="modalRemoverAtendente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remover Atendente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulário para remover atendente -->
                <form id="formRemoverAtendente" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- Dropdown para selecionar o atendente -->
                    <div class="form-group">
                        <label for="atendenteDropdown">Selecione o Atendente:</label>
                        <select class="form-control" id="atendenteDropdown">
                            <!-- Opções serão adicionadas dinamicamente via AJAX -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <!-- Botão de remover atendente -->
                <button type="button" class="btn btn-danger" id="btnRemoverAtendente">Remover</button>
            </div>
        </div>
    </div>
</div>





<!-- Modal "Remover Técnico" -->
<div class="modal fade" id="modalRemoverTecnico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remover Técnico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulário para remover técnico -->
                <form id="formRemoverTecnico" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- Dropdown para selecionar o técnico -->
                    <div class="form-group">
                        <label for="tecnicoDropdown">Selecione o Técnico:</label>
                        <select class="form-control" id="tecnicoDropdown">
                            <!-- Opções serão adicionadas dinamicamente via AJAX -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <!-- Botão de remover técnico -->
                <button type="button" class="btn btn-danger" id="btnRemoverTecnico">Remover</button>
            </div>
        </div>
    </div>
</div>





<!-- Modal HTML -->
<div class="modal fade" id="registerClientModal" tabindex="-1" role="dialog" aria-labelledby="registerClientModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="registerClientModalLabel">Registrar Cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="registerClientForm" method="POST" action="{{ route('clientes.store') }}">
              @csrf
              <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="form-group">
                <label for="phone_number">Telefone</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
              </div>
              <div class="form-group">
                <label for="cpf_cnpj">CPF/CNPJ</label>
                <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" required>
              </div>
              <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" required>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="state">Estado</label>
                  <input type="text" class="form-control" id="state" name="state" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="city">Cidade</label>
                  <input type="text" class="form-control" id="city" name="city" required>
                </div>
              </div>
              <div class="form-group">
                <label for="neighborhood">Bairro</label>
                <input type="text" class="form-control" id="neighborhood" name="neighborhood" required>
              </div>
              <div class="form-row">
                <div class="form-group col-md-8">
                  <label for="street">Rua</label>
                  <input type="text" class="form-control" id="street" name="street" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="house_number">Número</label>
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




















<div class="modal fade" id="modalCriarGarantia" tabindex="-1" role="dialog" aria-labelledby="modalCriarGarantiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCriarGarantiaLabel">Criar Garantia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-garantia" action="{{ route('garantias.store') }}" method="POST">
                @csrf <!-- Diretiva Blade para gerar token CSRF -->
                <div class="modal-body">
                    <fieldset>
                        <legend>Dados do Cliente</legend>
                        <div class="form-group">
                            <label for="clienteGarantia">Buscar Cliente:</label>
                            <input type="text" id="clienteGarantia" name="clienteGarantia" class="form-control" placeholder="Digite o nome do cliente" required>
                            <div id="lista-clientes-garantia" class="list-group" style="position: absolute; z-index: 1000; width: 100%;"></div>
                        </div>

                        <div id="dados-cliente-garantia" style="display: none;">

                        <div class="form-group">
                                <label for="phone_numberGarantia">Telefone:</label>
                                <input type="text" id="phone_numberGarantia" name="phone_numberGarantia" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="stateGarantia">Estado:</label>
                                <input type="text" id="stateGarantia" name="stateGarantia" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="cidadeGarantia">Cidade:</label>
                                <input type="text" id="cidadeGarantia" name="cidadeGarantia" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="cepGarantia">CEP:</label>
                                <input type="text" id="cepGarantia" name="cepGarantia" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="ruaGarantia">Rua:</label>
                                <input type="text" id="ruaGarantia" name="ruaGarantia" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="bairroGarantia">Bairro:</label>
                                <input type="text" id="bairroGarantia" name="bairroGarantia" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="numeroGarantia">Número:</label>
                                <input type="text" id="numeroGarantia" name="numeroGarantia" class="form-control" required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Dados da Garantia</legend>
                        <div class="form-group">
                            <label for="tipoGarantia">Tipo de Garantia:</label>
                            <select id="tipoGarantia" name="tipoGarantia" class="form-control" required>
                                <option value="">Selecione o Tipo</option>
                                <option value="produto">Produto</option>
                                <option value="servico">Serviço</option>
                            </select>
                        </div>

                        <div class="form-group" id="camposProduto" style="display: none;">
                            <label for="nomeProduto">Nome do Produto:</label>
                            <input type="text" id="nomeProduto" name="nomeProduto" class="form-control">

                            <label for="tempoGarantiaProduto">Tempo de Garantia (em dias):</label>
                            <input type="number" id="tempoGarantiaProduto" name="tempoGarantiaProduto" class="form-control">
                        </div>

                        <div class="form-group" id="camposServico" style="display: none;">
                            <label for="servicoRealizado">Serviço Realizado:</label>
                            <input type="text" id="servicoRealizado" name="servicoRealizado" class="form-control">

                            <label for="modeloAparelho">Modelo do Aparelho:</label>
                            <input type="text" id="modeloAparelho" name="modeloAparelho" class="form-control">

                            <label for="tempoGarantiaServico">Tempo de Garantia (em dias):</label>
                            <input type="number" id="tempoGarantiaServico" name="tempoGarantiaServico" class="form-control">
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
                // Captura os campos preenchidos automaticamente
                name: $('#clienteGarantia').val(),
                city: $('#cidadeGarantia').val(),
                phone_number: $('#phone_numberGarantia').val(),
                cep: $('#cepGarantia').val(),
                street: $('#ruaGarantia').val(),
                neighborhood: $('#bairroGarantia').val(),
                house_number: $('#numeroGarantia').val(),
                state: $('#stateGarantia').val(),
            };

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
                    window.location.href = "{{ route('gerar_pdf_ultima_garantia') }}";// Fechar o modal após o salvamento
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
                    $('#cidadeGarantia').attr('readonly', false);
                    $('#phone_numberGarantia').attr('readonly', false);
                    $('#cepGarantia').attr('readonly', false);
                    $('#ruaGarantia').attr('readonly', false);
                    $('#bairroGarantia').attr('readonly', false);
                    $('#numeroGarantia').attr('readonly', false);
                    $('#stateGarantia').attr('readonly', false);
                }
            });
        });
    });
</script>













































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


<!-- Coloque isso no final do seu arquivo HTML ou em um arquivo JavaScript separado -->
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



<!-- Script para carregar e remover técnicos -->
<script>
    $(document).ready(function() {
        // Carregar os nomes dos técnicos no dropdown
        $.get('tecnicos', function(data) {
            $.each(data, function(key, value) {
                $('#tecnicoDropdown').append($('<option>', {
                    value: key,
                    text: value
                }));
            });
        });

        // Evento de clique no botão "Remover" dentro do modal
        $('#modalRemoverTecnico').on('click', '#btnRemoverTecnico', function() {
            // Obter o ID do técnico selecionado no dropdown
            var tecnicoId = $('#tecnicoDropdown').val();

            // Atualizar o action do formulário com o ID selecionado
            $('#formRemoverTecnico').attr('action', 'remover-tecnico/' + tecnicoId);

            // Submeter o formulário para remover o técnico
            $('#formRemoverTecnico').submit();
        });

        // Manipular a submissão do formulário de remoção de técnico
        $('#formRemoverTecnico').on('submit', function(e) {
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
                        text: 'Técnico removido com sucesso.',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Opcional: remover o técnico do dropdown após a remoção
                    $('#tecnicoDropdown option[value="' + tecnicoId + '"]').remove();
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Houve um problema ao remover o técnico.',
                    });
                }
            });
        });
    });
</script>






<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS (versão 4) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Aguarda o documento ser carregado
    $(document).ready(function() {
        // Adiciona um evento de clique para itens do dropdown que abrem modais
        $('.dropdown-item[data-toggle="modal"]').on('click', function(event) {
            // Impede o comportamento padrão do link
            event.preventDefault();
            // Obtém o valor do atributo data-target para identificar o modal a ser exibido
            var targetModal = $(this).data('target');
            // Abre o modal correspondente
            $(targetModal).modal('show');
        });

        // Adiciona um evento de clique ao dropdown de Garantias para redirecionamento de links
        $('#navbarDropdownGarantia').on('click', function(event) {
            event.preventDefault(); // Impede o comportamento padrão do link
            // Seleciona o dropdown interno para Garantias
            var dropdownMenu = $(this).next('.dropdown-menu');
            // Exibe ou oculta suavemente o dropdown interno
            dropdownMenu.slideToggle('fast');
        });

        // Adiciona um evento de clique ao dropdown de Funcionários para redirecionamento de links
        $('#navbarDropdownFuncionarios').on('click', function(event) {
            event.preventDefault(); // Impede o comportamento padrão do link
            // Seleciona o dropdown interno para Funcionários
            var dropdownMenu = $(this).next('.dropdown-menu');
            // Exibe ou oculta suavemente o dropdown interno
            dropdownMenu.slideToggle('fast');
        });

        // Impede que o dropdown interno seja fechado quando clicamos dentro dele
        $('.dropdown-menu').on('click', function(event) {
            event.stopPropagation();
        });

        // Fecha o dropdown interno quando clicamos fora dele
        $(document).on('click', function(event) {
            $('.dropdown-menu').slideUp('fast');
        });
    });
</script>


<script>

document.addEventListener('DOMContentLoaded', function() {
    var modalRegistrarAtendente = new bootstrap.Modal(document.getElementById('modalRegistrarAtendente'));

    document.getElementById('btnRegistrarAtendente').addEventListener('click', function() {
        var nomeAtendente = document.getElementById('nomeAtendente').value;

        if (nomeAtendente.trim() === '') {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, insira o nome do atendente.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        fetch('registrar-atendente', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nomeAtendente: nomeAtendente })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('A resposta do servidor não foi OK');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                modalRegistrarAtendente.hide();
                Swal.fire({
                    title: 'Sucesso!',
                    text: data.success,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else if (data.error) {
                Swal.fire({
                    title: 'Erro!',
                    text: data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Ocorreu um erro:', error);
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível processar a sua solicitação.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
});


</script>


<script>

document.addEventListener('DOMContentLoaded', function() {
    // Inicializa o modal utilizando o seletor correto para o Bootstrap 5
    var modal = new bootstrap.Modal(document.getElementById('modalAdicionarTecnico'));

    // Manipular a submissão do formulário de adicionar técnico
    document.getElementById('btnAdicionarTecnico').addEventListener('click', function() {
        // Recupera o nome do técnico do campo de entrada
        var nomeTecnico = document.getElementById('nomeTecnico').value;

        // Verifica se o nome do técnico não está vazio antes de enviar a solicitação
        if (nomeTecnico.trim() === '') {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, insira o nome do técnico.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Interrompe a execução se o nome estiver vazio
        }

        fetch('adicionar-tecnico', { // Corrigido para corresponder à rota definida
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ nomeTecnico: nomeTecnico })
})
        .then(response => {
            if (!response.ok) {
                throw new Error('A resposta do servidor não foi OK');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Fecha o modal
                modal.hide();
                // Exibe um pop-up bonito com a mensagem de sucesso
                Swal.fire({
                    title: 'Sucesso!',
                    text: data.success,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else if (data.error) {
                // Exibe um pop-up bonito com a mensagem de erro
                Swal.fire({
                    title: 'Erro!',
                    text: data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Ocorreu um erro:', error);
            // Exibe um pop-up bonito com a mensagem de erro
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível processar a sua solicitação.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
});

</script>
