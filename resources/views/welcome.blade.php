<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Google tag (gtag.js) -->
    <!-- Adicionando o favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0KP0TXR5K4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0KP0TXR5K4');
</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Master-Os</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-1m5iE9AkZWGO2fz78r4E6CjC02m5r1oGM2CgyjxATDb1Ft/R8T5OBkHm9s9a8IV6ZJ/jdTDKqYdQ+cYBlf6aFw==" crossorigin="anonymous" />

    <!-- CSS Externo para o Framework de Imagens -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picnic-css/dist/picnic.min.css">

    <style>
        /* Reset de estilos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilos globais */
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Header */
        .header {
            background-color: #343a40;
            padding: 1rem 0;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .nav {
            display: flex;
            justify-content: flex-end;
        }

        .nav-link {
            margin-left: 1rem;
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-link:hover {
            background-color: #495057;
            color: #f8f9fa;
        }

        /* Main */
        .main {
            flex: 1;
            padding: 2rem 0;
            background-color: #f8f9fa;
        }

        .main h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #343a40;
            text-align: center;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .main p {
            font-size: 1.125rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #6c757d;
        }

        .features {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .feature {
            width: 100%; /* Alterado para ocupar 100% da largura em telas pequenas */
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .feature:hover {
            transform: translateY(-5px);
        }

        .feature .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #007bff;
        }

        .feature h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #343a40;
        }

        .feature p {
            font-size: 1rem;
            color: #6c757d;
        }

        /* Footer */
        .footer {
            background-color: #343a40;
            color: #f8f9fa;
            text-align: center;
            padding: 2rem 0;
            margin-top: auto;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        .footer p {
            margin-bottom: 1rem;
        }

        /* Dark Mode */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #121212;
                color: #e1e1e1;
            }

            .header {
                background-color: #1f1f1f;
            }

            .nav-link {
                color: #e1e1e1;
            }

            .nav-link:hover {
                background-color: #333;
                color: #e1e1e1;
            }

            .main h1,
            .main p,
            .feature h2,
            .feature p {
                color: #e1e1e1;
            }

            .footer {
                background-color: #1f1f1f;
            }
        }

        /* Media Queries para Telas Pequenas (Celulares) */
        @media only screen and (max-width: 768px) {
            .feature {
                width: calc(50% - 1rem); /* Alterado para ocupar 50% da largura em telas pequenas */
            }
        }

        @media only screen and (max-width: 576px) {
            .feature {
                width: 100%; /* Alterado para ocupar 100% da largura em telas extra pequenas */
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            @if (Route::has('login'))
                <nav class="nav">
                    @auth
                        <a href="{{ url('/home') }}" class="nav-link">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <main class="main">
        <div class="container">
            <h1>Seja bem-vindo ao Master-Os</h1>
            <p>Gestão da sua assistência técnica de forma eficiente e organizada.</p>

            <div class="features">
                <div class="feature">
                    <div class="icon"><i class="fas fa-cubes"></i></div>
                    <h2>Controle de Estoque</h2>
                    <p>Gerencie seu estoque de forma fácil e eficaz.</p>
                </div>
                <div class="feature">
                    <div class="icon"><i class="fas fa-coins"></i></div>
                    <h2>Fluxo de Caixa</h2>
                    <p>Mantenha o controle financeiro da sua empresa atualizado.</p>
                </div>
                <div class="feature">
                    <div class="icon"><i class="fas fa-shield-alt"></i></div>
                    <h2>Emissão de Garantia</h2>
                    <p>Emite garantias de forma simples e rápida para seus clientes.</p>
                </div>
                <div class="feature">
                    <div class="icon"><i class="fas fa-wrench"></i></div>
                    <h2>Ordem de Serviço</h2>
                    <p>Crie ordens de serviço detalhadas para melhor atender seus clientes.</p>
                </div>
                <div class="feature">
                    <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <h2>Orçamento</h2>
                    <p>Elabore orçamentos precisos para seus clientes com facilidade.</p>
                </div>
                <div class="feature">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <h2>CRM de Clientes</h2>
                    <p>Mantenha um relacionamento próximo com seus clientes.</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>O Master-Os é gratuito para você.</p>
            <p>Master-Os v1.9</p>
        </div>
    </footer>
</body>
</html>
