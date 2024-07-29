<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Funcionario;
use Illuminate\Http\JsonResponse;

class FuncionarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Recupera o nome do técnico do formulário
        $nomeTecnico = $request->input('nomeTecnico');

        // Verifica se o nome não está vazio
        if (empty($nomeTecnico)) {
            return response()->json(['error' => 'O nome do técnico não pode estar vazio.'], 422);
        }

        // Obtém o user_id do usuário autenticado
        $user_id = Auth::id();

        // Cria o técnico com base nos dados recebidos e no user_id
        Funcionario::create([
            'tecnico' => $nomeTecnico,
            'user_id' => $user_id,
        ]);

        // Retorna uma resposta JSON com sucesso
        return response()->json(['success' => 'Técnico adicionado com sucesso.'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        // Recupera o nome do atendente do formulário
        $nomeAtendente = $request->input('nomeAtendente');

        // Verifica se o nome não está vazio
        if (empty($nomeAtendente)) {
            return response()->json(['error' => 'O nome do atendente não pode estar vazio.'], 422);
        }

        // Obtém o user_id do usuário autenticado
        $user_id = Auth::id();

        // Cria o atendente com base nos dados recebidos e no user_id
        Funcionario::create([
            'atendente' => $nomeAtendente,
            'user_id' => $user_id,
        ]);

        // Retorna uma resposta JSON com sucesso
        return response()->json(['success' => 'Atendente adicionado com sucesso.'], 200);
    }

    /**
     * Get all atendentes from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAtendentes()
    {
        // Obtém o user_id do usuário autenticado
        $user_id = Auth::id();

        // Filtra para retornar apenas os atendentes associados ao user_id
        $atendentes = Funcionario::where('user_id', $user_id)
                                 ->where('atendente', 'regexp', '[A-Za-z0-9]')
                                 ->pluck('atendente', 'id')
                                 ->toArray();

        return response()->json($atendentes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Obtém o user_id do usuário autenticado
            $user_id = Auth::id();

            // Encontra o atendente pelo ID e pelo user_id e exclui
            Funcionario::where('id', $id)
                       ->where('user_id', $user_id)
                       ->delete();

            // Retorna uma resposta de sucesso vazia
            return response()->json(['success' => 'Atendente removido com sucesso.']);
        } catch (\Exception $e) {
            // Retorna uma resposta JSON de erro em caso de falha
            return response()->json(['error' => 'Erro ao remover o atendente'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyTecnico($id)
    {
        try {
            // Obtém o user_id do usuário autenticado
            $user_id = Auth::id();

            // Encontra o técnico pelo ID e pelo user_id e exclui
            Funcionario::where('id', $id)
                       ->where('user_id', $user_id)
                       ->delete();

            // Retorna uma resposta JSON de sucesso
            return response()->json(['success' => 'Técnico removido com sucesso']);
        } catch (\Exception $e) {
            // Retorna uma resposta JSON de erro em caso de falha
            return response()->json(['error' => 'Erro ao remover o técnico'], 500);
        }
    }

    /**
     * Get all técnicos from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTecnicos()
    {
        // Obtém o user_id do usuário autenticado
        $user_id = Auth::id();

        // Filtra para retornar apenas os técnicos associados ao user_id
        $tecnicos = Funcionario::where('user_id', $user_id)
                               ->whereNotNull('tecnico')
                               ->where('tecnico', '<>', '')
                               ->pluck('tecnico', 'id')
                               ->toArray();

        return response()->json($tecnicos);
    }
}
