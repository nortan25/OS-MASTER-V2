<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notificacoes;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function verificarNotificacoes()
    {
        $user_id = Auth::id(); // Obtém o ID do usuário logado

        // Verifica se já foi exibida uma notificação hoje
        $foiExibidaHoje = notificacoes::where('usuario_id', $user_id)
            ->whereDate('exibida_em', now()->toDateString()) // Filtra pelo dia atual
            ->exists();

        // Busca as notificações pendentes para o usuário logado que ainda não foram exibidas
        $notificacoesPendentes = notificacoes::where('usuario_id', $user_id)
            ->whereNull('exibida_em') // Verifica se a notificação ainda não foi exibida
            ->orderBy('created_at', 'desc') // Ordena por data de criação (opcional)
            ->get();

        if ($notificacoesPendentes->isEmpty()) {
            return response()->json([
                'temNotificacao' => false,
                'mensagem' => null,
                'tipo' => null
            ]);
        } else {
            $notificacao = $notificacoesPendentes->first();
            return response()->json([
                'temNotificacao' => true,
                'mensagem' => $notificacao->mensagem,
                'tipo' => $notificacao->tipo
            ]);
        }
    }

    public function atualizarExibicaoNotificacao($notificacao_id)
    {
        $notificacao = notificacoes::find($notificacao_id);

        if ($notificacao) {
            // Verifica se o campo exibida_em está nulo ou se é um dia diferente do dia atual
            if ($notificacao->exibida_em === null || !$notificacao->exibida_em->isToday()) {
                $notificacao->exibida_em = now();
                $notificacao->save();
            }
        }
    }
}
