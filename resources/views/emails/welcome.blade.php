<x-mail::message>
    <style>
        /* Estilos gerais */
        .email-container {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .email-header {
            background-color: #3490dc;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .email-content {
            padding: 20px;
            background-color: #ffffff;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .button {
            margin-top: 20px;
            text-align: center;
        }

        .button a {
            display: inline-block;
            background-color: #3490dc;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .button a:hover {
            background-color: #2779bd;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 10px;
        }

        strong {
            color: #3490dc;
        }
    </style>

    <div class="email-container">
        <div class="email-header">
            <h1>Bem-Vindo ao {{ config('app.name') }}</h1>
        </div>

        <div class="email-content">
            <p>Olá ,</p>

            <p>Seja bem-vindo à nossa plataforma. Estamos felizes em tê-lo conosco!</p>

            <p>Aqui estão algumas informações úteis para começar:</p>
            <ul>
                <li><strong>Explore nossos serviços:</strong> Descubra o que oferecemos para você.</li>
                <li><strong>Personalize seu perfil:</strong> Adicione informações adicionais ao seu perfil.</li>
                <li><strong>Entre em contato:</strong> Não hesite em nos contatar se precisar de assistência.</li>
            </ul>

            <div class="button">
                <a href="{{ route('home') }}">Acessar Minha Conta</a>
            </div>

            <p>Obrigado por escolher {{ config('app.name') }}!</p>

            <p>Atenciosamente,<br>
            Equipe {{ config('app.name') }}</p>
        </div>
    </div>
</x-mail::message>
