<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Master-OS </title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Master-Os | Unfixed Sidebar">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)-->
</head> <!--end::Head--> <!--begin::Body-->
<!-- Adicionando o favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">



 <style>
        @media (max-width: 768px) {
            body {
                padding-top: 56px; /* Ajuste o valor conforme necessário */
            }

            .navbar {
                position: fixed;
                top: 0;
                width: 100%;
                z-index: 1030;
            }

            .navbar-nav {
                flex-direction: column;
                width: 100%;
            }

            .navbar-nav .nav-item {
                text-align: center;
            }

            .user-menu .dropdown-menu {
                width: 100%;
                text-align: center;
            }
        }

        .user-image {
            max-width: 40px;
        }
    </style>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
    <a href="{{ route('home') }}" class="nav-link">Home</a>
</li>
<li class="nav-item d-none d-md-block">
    <a href="https://api.whatsapp.com/send?phone=5534999442627" class="nav-link" target="_blank">Duvidas e Suporte Gratuito </a>
</li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        @php
            $userId = Auth::id(); // Obtém o ID do usuário logado
            $userLogoPath = public_path('images/logo_' . $userId . '.jpg'); // Caminho completo para a imagem da logo do usuário

            if (file_exists($userLogoPath)) {
                $logoSrc = asset('images/logo_' . $userId . '.jpg'); // Caminho para a logo do usuário
            } else {
                $logoSrc = asset('images/logo_default.jpg'); // Caso não exista, exibe a logo padrão
            }
        @endphp
        <img src="{{ $logoSrc }}" class="user-image rounded-circle shadow" alt="User Image" style="max-width: 40px;"> <!-- Limita o tamanho da imagem para 40px de largura -->
        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <li class="user-header text-bg-primary">
            <img id="logoPreview" src="{{ $logoSrc }}" alt="Logo do Sistema" style="max-width: 200px;"> <!-- Tamanho máximo da logo do sistema -->
            <p>
                {{ Auth::user()->name }} - Seja bem vindo !
                <small>Menbro desde de  {{ Auth::user()->created_at->format('M. Y') }}</small>
            </p>
        </li>
        <li class="user-footer">
            <a href="{{ route('ajustes') }}" class="btn btn-default btn-flat">Ajustes</a>
            <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>
    </ul>
</li>


                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="#" class="brand-link">
                    <img src="dist/assets/img/M.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
                    <span class="brand-text fw-light">Master-Os</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Dashboard
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Home</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Caixa -->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon bi bi-box-seam"></i>
                                <p>
                                    Caixa
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('caixa.iniciar') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Iniciar Caixa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('historico.caixa') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Histórico de Caixa</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Estoque -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-clipboard-fill"></i>
                                <p>
                                    Estoque
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
    <li class="nav-item">
        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#registerStockModal">
            <i class="nav-icon bi bi-circle"></i>
            <p>Registrar Estoque</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('estoque.index') }}" class="nav-link">
            <i class="nav-icon bi bi-circle"></i>
            <p>Ver Estoque</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#darBaixaModal">
            <i class="nav-icon bi bi-circle"></i>
            <p>Baixa no Estoque</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#darEntradaModal">
            <i class="nav-icon bi bi-circle"></i>
            <p>Entrada no Estoque</p>
        </a>
    </li>
</ul>
<!-- RELATÓRIOS -->
<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon bi bi-bar-chart"></i> <!-- Ícone para Relatórios -->
        <p>
            Relatórios
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('relatorios') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Relatórios Brutos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('lucro.relatorios') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Relatórios de Lucro</p>
            </a>
        </li>
    </ul>
</li>


                        <!-- Funcionários -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-people"></i>
                                <p>
                                    Funcionários
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalRegistrarAtendente">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Adicionar Atendente</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalAdicionarTecnico">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Adicionar Técnico</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalRemoverAtendente">




                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Remover Atendente</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalRemoverTecnico">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Remover Técnico</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Garantia -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-shield-check"></i>
                                <p>
                                    Garantia
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalCriarGarantia">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Criar Garantia</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('historico_garantias') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Histórico de Garantias</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Clientes -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-person-check"></i>
                                <p>
                                    Clientes
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#registerClientModal">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Registrar Cliente</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('clientes.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Lista de Clientes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Histórico de Ordem -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>
                                    Histórico de Ordem
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ordens.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Lista de Ordens</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('orcamentos.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Lista de Orçamentos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Ordem -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-list-check"></i>
                                <p>
                                    Ordem
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('adicionar_orcamento') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Criar Orçamento</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('adicionar_ordem') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Criar Ordem</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <!-- Conteúdo principal aqui -->
            @yield('content')
        </div>
    </div>

    <!-- Modais -->
    @include('modal.Reg_produto')
    @include('modal.Reg_atendente')
    @include('modal.Reg_tecnico')
    @include('modal.Rem_atendente')
    @include('modal.Rem_tecnico')
    @include('modal.Reg_cliente')
    @include('modal.Reg_garantia')
    @include('modal.baixa_estoque')
    @include('modal.ent_estoque')
    @include('modal.add_ordem')

    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="dist/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!--end::Script-->
</body><!--end::Body-->
<footer class="app-footer"> <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Otimo trabalho!</div> <!--end::To the end--> <!--begin::Copyright--> <strong>
                Copyright &copy; 2024-2024&nbsp;
                <a href="https://adminlte.io" class="text-decoration-none">Master-Os</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer> <!--end::Footer-->

</html>