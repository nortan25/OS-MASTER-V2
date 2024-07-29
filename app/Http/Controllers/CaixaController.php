<?php

// app/Http/Controllers/CaixaController.php

namespace App\Http\Controllers;
use App\Models\Caixas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Controle;
use Illuminate\Support\Facades\Hash;


class CaixaController extends Controller





{


    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }


    public function iniciarCaixa()
    {
        // Lógica para iniciar o caixa, como definir valor inicial, registrar abertura do dia, etc.
        
        // Exemplo simples de retorno
        return view('caixa.iniciar');
    }

   

   
    
        /**
         * Salva o valor inicial do caixa.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function salvarValorInicial(Request $request)
        {
            // Validação dos dados do formulário
           // Validação dos dados do formulário
    $request->validate([
        'valorInicial' => 'required|numeric|min:0',
    ]);

    try {
        $user_id = auth()->user()->id;
        $today = now()->toDateString();

        // Verifica se já existe um registro de caixa aberto para o usuário no mesmo dia
        $caixaExistente = Caixas::where('user_id', $user_id)
                                ->whereDate('created_at', $today)
                                ->first();

        if ($caixaExistente) {
            // Atualiza o valor inicial do caixa existente
            $caixaExistente->update([
                'valor_inicial' => $request->input('valorInicial')
            ]);

            // Resposta de sucesso ao atualizar o valor inicial
            return response()->json(['success' => true, 'message' => 'Valor inicial do caixa atualizado com sucesso!', 'data' => $caixaExistente]);
        } else {
            // Cria um novo registro de caixa com o valor inicial
            $caixa = new Caixas();
            $caixa->valor_inicial = $request->input('valorInicial');
            $caixa->user_id = $user_id;
            $caixa->save();

            // Resposta de sucesso ao criar um novo registro de caixa
            return response()->json(['success' => true, 'message' => 'Valor inicial do caixa registrado com sucesso!', 'data' => $caixa]);
        }
    } catch (\Exception $e) {
        // Resposta de erro caso ocorra uma exceção
        return response()->json(['error' => true, 'message' => 'Erro ao salvar o valor inicial do caixa: ' . $e->getMessage()]);
    }
}
/**
     * Retorna os registros de caixa do usuário para o dia atual.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCaixas(Request $request)
    {
        try {
            $user_id = auth()->user()->id;
            $today = Carbon::now()->toDateString();

            // Busca todos os registros de caixa do usuário para o dia atual
            $caixas = Caixas::where('user_id', $user_id)
                            ->whereDate('created_at', $today)
                            ->get();

            // Prepara os dados para retorno em formato JSON
            $data = [
                'caixas' => $caixas
            ];

            // Retorna a resposta em formato JSON para o frontend
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            // Em caso de erro, retorna uma resposta de erro
            return response()->json(['error' => true, 'message' => 'Erro ao buscar os registros de caixa: ' . $e->getMessage()]);
        }
    }








/**
 * Verifica se há registros de valor_inicial e total_caixa para o dia atual e retorna o estado do caixa.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function getCaixaStatus(Request $request)
{
    try {
        $user_id = auth()->user()->id;
        $today = Carbon::now()->toDateString();

        // Verifica se há registro de valor_inicial para o dia atual
        $valorInicial = Caixas::where('user_id', $user_id)
                            ->whereDate('created_at', $today)
                            ->whereNotNull('valor_inicial')
                            ->exists();

        // Verifica se há registro de total_caixa para o dia atual
        $totaldia = Caixas::where('user_id', $user_id)
                            ->whereDate('created_at', $today)
                            ->whereNotNull('total_dia')
                            ->exists();

        // Define o estado do caixa com base nas verificações
        if (!$valorInicial) {
            $caixaStatus = 'fechado'; // Se não há valor inicial, o caixa está fechado
        } elseif (!$totaldia) {
            $caixaStatus = 'aberto'; // Se há valor inicial mas não há total caixa, o caixa está aberto
        } else {
            $caixaStatus = 'fechado'; // Se há valor inicial e total caixa, o caixa está fechado para o dia
        }

        // Retorna a resposta em formato JSON para o frontend
        return response()->json(['success' => true, 'caixa_status' => $caixaStatus]);
    } catch (\Exception $e) {
        // Em caso de erro, retorna uma resposta de erro
        return response()->json(['error' => true, 'message' => 'Erro ao verificar o estado do caixa: ' . $e->getMessage()]);
    }
}









   
    /**
     * Registra uma nova venda.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrarVenda(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
        ]);

        // Processa os dados recebidos
        $descricao = $request->input('descricao');
        $valor = $request->input('valor');

        // Cria uma nova instância do modelo Caixas
        $caixa = new Caixas();
        $caixa->descricao = $descricao;
        $caixa->venda = $valor;
        $caixa->user_id = Auth::id(); // Obtém o ID do usuário logado
        $caixa->save();

        // Retorna a resposta em formato JSON para o frontend
        return response()->json(['success' => true, 'message' => 'Venda registrada com sucesso.']);
    }



/**
     * Registra uma nova saída.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrarSaida(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
        ]);

        // Processa os dados recebidos
        $descricao = $request->input('descricao');
        $valor = $request->input('valor');

        // Cria uma nova instância do modelo Caixas
        $caixa = new Caixas();
        $caixa->descricao = $descricao;
        $caixa->saida = $valor;
        $caixa->user_id = Auth::id(); // Obtém o ID do usuário logado
        $caixa->save();

        // Retorna a resposta em formato JSON para o frontend
        return response()->json(['success' => true, 'message' => 'Venda registrada com sucesso.']);
    }



/**
     * Registra uma nova despesa fixa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(Request $request)
    {
       // Validação dos dados do formulário
       $request->validate([
        'descricao' => 'required|string|max:255',
        'valor' => 'required|numeric',
    ]);

    // Processa os dados recebidos
    $descricao = $request->input('descricao');
    $valor = $request->input('valor');

    // Cria uma nova instância do modelo Caixas
    $caixa = new Caixas();
    $caixa->descricao = $descricao;
    $caixa->despesa_fixa = $valor;
    $caixa->user_id = Auth::id(); // Obtém o ID do usuário logado
    $caixa->save();

    // Retorna a resposta em formato JSON para o frontend
    return response()->json(['success' => true, 'message' => 'Venda registrada com sucesso.']);
}





 /**
 * Registra o valor total do dia na tabela de caixas.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function registrarValorTotalDia(Request $request)
{
    // Validação dos dados do formulário (no seu caso, apenas a presença do campo)
    $request->validate([
        'totalDia' => 'required|numeric|',
    ]);

    try {
        // Obtém o ID do usuário autenticado
        $user_id = Auth::id();
        // Obtém a data atual
        $today = now()->toDateString();

        // Verifica se já existe um registro de caixa fechado para o usuário no mesmo dia
        $caixaFechado = Caixas::where('user_id', $user_id)
                              ->whereDate('created_at', $today)
                              ->whereNotNull('total_dia') // Verifica se foi fechado
                              ->first();

        if ($caixaFechado) {
            // Se encontrou um registro de caixa fechado no mesmo dia, atualiza o total_dia
            $caixaFechado->update([
                'total_dia' => $request->input('totalDia')
            ]);

            // Resposta de sucesso ao atualizar o total do dia
            return response()->json(['success' => true, 'message' => 'Total do dia atualizado com sucesso!', 'data' => $caixaFechado]);
        } else {
            // Se não encontrou um registro de caixa fechado no mesmo dia, cria um novo registro
            $novoRegistro = new Caixas();
            $novoRegistro->total_dia = $request->input('totalDia');
            $novoRegistro->user_id = $user_id;
            $novoRegistro->save();

            // Resposta de sucesso ao criar um novo registro de caixa com o total do dia
            return response()->json(['success' => true, 'message' => 'Registro do total do dia criado com sucesso!', 'data' => $novoRegistro]);
        }
    } catch (\Exception $e) {
        // Resposta de erro caso ocorra uma exceção
        return response()->json(['error' => true, 'message' => 'Erro ao salvar o total do dia: ' . $e->getMessage()]);
    }
}




public function historicoCaixa(Request $request)
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        $userId = Auth::id();

        // Obter controle do usuário usando o modelo
        $controle = Controle::where('user_id', $userId)->first();

        // Verificar se o controle exige senha para histórico de caixa
        if ($controle && $controle->historico_de_caixa == 1) {
            if ($request->isMethod('post') && $request->has('senha')) {
                // Verifica a senha fornecida
                $senha = $request->input('senha');
                 if (Hash::check($senha, $controle->password)) {
                    // Senha correta, continua o processamento
                    return $this->processarHistorico($request, $userId);
                } else {
                    // Senha incorreta
                    return response()->json(['error' => 'Senha incorreta.'], 403);
                }
            }

            // Se a senha não for fornecida, exibe o modal
            return view('modal.historico-senha-modal');
        }

        // Se não houver controle ou não é necessário senha, continua o processamento
        return $this->processarHistorico($request, $userId);
    }

    /**
     * Processa o histórico de caixa com base nos filtros fornecidos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    protected function processarHistorico(Request $request, int $userId)
    {
        $query = Caixas::query()->where('user_id', $userId);

        // Filtrar por ano, se fornecido
        if ($request->has('ano')) {
            $query->whereYear('created_at', $request->ano);
        }

        // Filtrar por mês, se fornecido
        if ($request->has('mes')) {
            $query->whereMonth('created_at', $request->mes);
        }

        // Filtrar por dia, se fornecido
        if ($request->has('dia')) {
            $query->whereDay('created_at', $request->dia);
        }

        $caixas = $query->get();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'data' => ['caixas' => $caixas]]);
        }

        return view('caixa.historico', compact('caixas'));
    }
}
