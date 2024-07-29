@component('mail::message')
    # Senha Alterada

    Olá ,

    Este é um email para confirmar que sua senha foi alterada com sucesso.

    Se você não realizou esta alteração, entre em contato conosco imediatamente.

    Obrigado por usar nosso serviço!

    Atenciosamente,<br>
    {{ config('app.name') }}
@endcomponent
