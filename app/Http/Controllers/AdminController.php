<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importa o modelo User
use App\Models\Ordem; // Importa o modelo Ordem
use App\Models\notificacoes;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count(); // Obtém o total de usuários
        $totalOrdens = Ordem::count(); // Obtém o total de ordens

        return view('admin.dashboard', compact('totalUsers', 'totalOrdens')); // Passa o total de usuários e ordens para a visualização
    }




    public function enviarNotificacaoGeral(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensagem' => 'required|string',
            'tipo' => 'required|string|in:geral,diaria,travamento,usuario_especifico',
            'usuario_id' => 'nullable|exists:users,id',
        ]);

        // Determinar o tipo de notificação com base no tipo selecionado
        switch ($request->tipo) {
            case 'geral':
                // Criação da notificação geral para todos os usuários
                $usuarios = User::all(); // Obtém todos os usuários

                foreach ($usuarios as $usuario) {
                    Notificacao::create([
                        'tipo' => 'geral',
                        'titulo' => $request->titulo,
                        'mensagem' => $request->mensagem,
                        'usuario_id' => $usuario->id,
                    ]);
                }
                break;

            case 'diaria':
                // Lógica para notificação diária (uma vez por dia)
                // Implemente aqui a lógica necessária
                break;

            case 'travamento':
                // Lógica para notificação de travamento
                // Implemente aqui a lógica necessária
                break;

            case 'usuario_especifico':
                // Criação da notificação para usuário específico
                if ($request->usuario_id) {
                    Notificacao::create([
                        'tipo' => 'usuario_especifico',
                        'titulo' => $request->titulo,
                        'mensagem' => $request->mensagem,
                        'usuario_id' => $request->usuario_id,
                    ]);
                } else {
                    return redirect()->route('admin.dashboard')->with('error', 'É necessário selecionar um usuário específico.');
                }
                break;

            default:
                return redirect()->route('admin.dashboard')->with('error', 'Tipo de notificação inválido.');
        }

        return redirect()->route('admin.dashboard')->with('success', 'Notificação enviada com sucesso.');
    }

    // Método para buscar usuários por ID ou nome
    public function buscarUsuarios(Request $request)
    {
        $termo = $request->termo;

        // Busca usuários pelo ID ou nome
        $usuarios = User::where('id', $termo)
                    ->orWhere('name', 'like', '%'.$termo.'%')
                    ->get();

        return response()->json($usuarios); // Retorna os usuários encontrados em formato JSON
    }
}