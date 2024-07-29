<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\Caixas;
use App\Models\Ordem;
use App\Models\Estoque;
use App\Models\Garantia;
use App\Models\Orcamento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    


public function index(Request $request)
{
    try {
        $user = Auth::user();

        // Inicializa as variáveis com valores padrão
        $totalOrdens = 0;
        $totalClientes = 0;
        $totalFuncionarios = 0;
        $totalCaixaDiario = 0;
        $totalProdutosRegistrados = 0;
        $totalGarantias = 0;
        $totalOrcamentos = 0;
        $produtosBaixoEstoque = [];
        $caixaStatus = 'fechado'; // Valor padrão inicial

        // Obtém o total de Ordens do usuário autenticado
        if ($user) {
            $totalOrdens = Ordem::where('user_id', $user->id)->count();
        }

        // Obtém o total de Clientes do usuário autenticado
        if ($user) {
            $totalClientes = Cliente::where('user_id', $user->id)->count();
        }

        // Obtém o total de Funcionários do usuário autenticado
        if ($user) {
            $totalFuncionarios = Funcionario::where('user_id', $user->id)->count();
        }

        // Filtragem do total do Caixa Diário do usuário autenticado
        if ($user) {
            // Filtro por dia
            if ($request->has('filter') && $request->filter == 'daily') {
                $totalCaixaDiario = $this->getTotalCaixaDiario($user, 'day');
            }
            // Filtro por semana
            elseif ($request->has('filter') && $request->filter == 'weekly') {
                $totalCaixaDiario = $this->getTotalCaixaDiario($user, 'week');
            }
            // Filtro por mês
            elseif ($request->has('filter') && $request->filter == 'monthly') {
                $totalCaixaDiario = $this->getTotalCaixaDiario($user, 'month');
            }
            // Filtro por ano
            elseif ($request->has('filter') && $request->filter == 'yearly') {
                $totalCaixaDiario = $this->getTotalCaixaDiario($user, 'year');
            }
            // Caso nenhum filtro seja aplicado, calcula para o dia atual
            else {
                $totalCaixaDiario = $this->getTotalCaixaDiario($user, 'day');
            }
        }

        // Obtém o total de Produtos Registrados do usuário autenticado
        if ($user) {
            $totalProdutosRegistrados = Estoque::where('user_id', $user->id)->count();
        }

        // Obtém o total de Garantias do usuário autenticado
        if ($user) {
            $totalGarantias = Garantia::where('user_id', $user->id)->count();
        }

        // Obtém o total de Orçamentos do usuário autenticado
        if ($user) {
            $totalOrcamentos = Orcamento::where('user_id', $user->id)->count();
        }

        // Verifica o estado do caixa para o usuário autenticado
        if ($user) {
            $today = Carbon::now()->toDateString();

            // Verifica se há registro de valor_inicial para o dia atual
            $valorInicial = Caixas::where('user_id', $user->id)
                                ->whereDate('created_at', $today)
                                ->whereNotNull('valor_inicial')
                                ->exists();

            // Verifica se há registro de total_caixa para o dia atual
            $totaldia = Caixas::where('user_id', $user->id)
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
        }

        // Obtém produtos com baixo estoque do usuário autenticado
        if ($user) {
            $produtosBaixoEstoque = Estoque::where('user_id', $user->id)
                ->where('quantidade', '<', 10)
                ->get();
        }

        // Retorna a view 'home' com os dados necessários
        return view('home', compact(
            'totalOrdens',
            'totalClientes',
            'totalFuncionarios',
            'totalCaixaDiario',
            'totalProdutosRegistrados',
            'totalGarantias',
            'totalOrcamentos',
            'produtosBaixoEstoque',
            'caixaStatus'
        ));
    } catch (\Exception $e) {
        // Em caso de erro, retorna uma resposta de erro
        return response()->json(['error' => true, 'message' => 'Erro ao carregar página inicial: ' . $e->getMessage()]);
    }
}


    /**
 * Retorna o total do caixa diário com base no filtro (dia, semana, mês, ano).
 *
 * @param \App\Models\User $user
 * @param string $filterType
 * @return float
 */
private function getTotalCaixaDiario($user, $filterType)
{
    $totalVendas = 0;
    $totalSaidas = 0;
    $totalDespesasFixas = 0;
    $valorInicial = Caixas::where('user_id', $user->id)
        ->where(function ($query) use ($filterType) {
            switch ($filterType) {
                case 'day':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereYear('created_at', Carbon::now()->year)
                          ->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                default:
                    break;
            }
        })
        ->sum('valor_inicial');

    switch ($filterType) {
        case 'day':
            $totalVendas = Caixas::where('user_id', $user->id)
                ->whereDate('created_at', Carbon::today())
                ->sum('venda');

            $totalSaidas = Caixas::where('user_id', $user->id)
                ->whereDate('created_at', Carbon::today())
                ->sum('saida');

            $totalDespesasFixas = Caixas::where('user_id', $user->id)
                ->whereDate('created_at', Carbon::today())
                ->sum('Despesa_Fixa');
            break;

        case 'week':
            $totalVendas = Caixas::where('user_id', $user->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('venda');

            $totalSaidas = Caixas::where('user_id', $user->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('saida');

            $totalDespesasFixas = Caixas::where('user_id', $user->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('Despesa_Fixa');
            break;

        case 'month':
            $totalVendas = Caixas::where('user_id', $user->id)
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('venda');

            $totalSaidas = Caixas::where('user_id', $user->id)
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('saida');

            $totalDespesasFixas = Caixas::where('user_id', $user->id)
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('Despesa_Fixa');
            break;

        case 'year':
            $totalVendas = Caixas::where('user_id', $user->id)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('venda');

            $totalSaidas = Caixas::where('user_id', $user->id)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('saida');

            $totalDespesasFixas = Caixas::where('user_id', $user->id)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('Despesa_Fixa');
            break;

        default:
            break;
    }

    return $totalVendas - $totalSaidas - $totalDespesasFixas + $valorInicial;
}
}
