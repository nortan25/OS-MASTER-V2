@extends('layouts.bar')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0KP0TXR5K4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0KP0TXR5K4');
</script>
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Card: Total de Ordens -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total de Ordens</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalOrdens }}</h5>
                </div>
            </div>
        </div>

        <!-- Card: Total de Clientes -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total de Clientes</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalClientes }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Card: Total de Funcionários -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total de Funcionários</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalFuncionarios }}</h5>
                </div>
            </div>
        </div>

        <!-- Card: Total de Produtos Registrados -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total de Produtos Registrados</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalProdutosRegistrados }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Card: Total do Caixa Diário -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card mb-4">
                <div class="card-header">Total do Caixa Diário</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ number_format($totalCaixaDiario, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>

        <!-- Card: Status do Caixa -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Status do Caixa</div>
                <div class="card-body">
                    <h5 class="card-title" id="statusCaixaTexto">{{ $caixaStatus }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Card: Produtos com Baixo Estoque -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card mb-4">
                <div class="card-header">Produtos com Baixo Estoque</div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($produtosBaixoEstoque as $produto)
                            <li class="list-group-item">{{ $produto->nome_produto }}</li>
                        @empty
                            <li class="list-group-item">Nenhum produto com baixo estoque</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
