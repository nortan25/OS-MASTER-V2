<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caixas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Controle;
use Illuminate\Support\Facades\Hash;

class RelatoriosController extends Controller
{
    public function index()
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        $userId = Auth::id();
        $controle = Controle::where('user_id', $userId)->first();

        // Verificar se o controle exige senha para relatórios brutos
        if ($controle && $controle->relatorio_bruto == 1) {
            return view('modal.relatorios-bruto-senha-modal');
        }

        return view('relatorios.index');
    }

    public function lucro()
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        $userId = Auth::id();
        $controle = Controle::where('user_id', $userId)->first();

        // Verificar se o controle exige senha para relatórios de lucro
        if ($controle && $controle->relatorio_lucro == 1) {
            return view('modal.relatorios-lucro-senha-modal');
        }

        return view('relatorios.lucro-index');
    }

    public function getReportData(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,monthly,weekly',
            'year' => 'nullable|integer',
            'month' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $userId = Auth::id(); // Pega o ID do usuário logado

        // Obter o período selecionado
        $period = $request->input('period');
        $year = $request->input('year');
        $month = $request->input('month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Inicializa a query base
        $query = Caixas::where('user_id', $userId);

        // Calcular o valor total conforme o período selecionado
        if ($period == 'monthly') {
            $query->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, 
                SUM(venda) as total')
                ->groupBy('month', 'year');

            if ($month) {
                $query->whereMonth('created_at', $month);
            }

            if ($year) {
                $query->whereYear('created_at', $year);
            }

            $reportData = $query->get()->map(function ($item) {
                $monthName = Carbon::create()->month($item->month)->format('F'); // Nome do mês
                return [
                    'date' => $monthName . ' ' . $item->year,
                    'total' => $item->total,
                ];
            });
        } elseif ($period == 'daily') {
            $query->selectRaw('DATE(created_at) as date, SUM(venda) as total')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('date');

            $reportData = $query->get()->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('d/m/Y'), // Formatar data
                    'total' => $item->total,
                ];
            });
        } elseif ($period == 'weekly') {
            $query->selectRaw('YEAR(created_at) as year, WEEK(created_at) as week, 
                SUM(venda) as total')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('year', 'week');

            $reportData = $query->get()->map(function ($item) {
                $startOfWeek = Carbon::now()->setISODate($item->year, $item->week, 1);
                $endOfWeek = $startOfWeek->copy()->endOfWeek();
                return [
                    'date' => $startOfWeek->format('d/m/Y') . ' - ' . $endOfWeek->format('d/m/Y'),
                    'total' => $item->total,
                ];
            });
        } else {
            return response()->json(['error' => 'Invalid period type'], 400);
        }

        return response()->json($reportData);
    }

    public function getProfitReportData(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,monthly,weekly',
            'year' => 'nullable|integer',
            'month' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $userId = Auth::id(); // Pega o ID do usuário logado

        // Obter o período selecionado
        $period = $request->input('period');
        $year = $request->input('year');
        $month = $request->input('month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Log de debug para verificar os parâmetros de entrada
        Log::info('Request parameters:', $request->all());

        // Inicializa a query base usando COALESCE para tratar NULL como zero
        $query = Caixas::selectRaw('SUM(COALESCE(venda, 0) - (COALESCE(saida, 0) + COALESCE(despesa_fixa, 0))) as profit')
            ->where('user_id', $userId);

        // Adiciona os filtros de data conforme o período selecionado
        if ($period == 'monthly') {
            $query->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year')
                ->groupBy('month', 'year');

            if ($month) {
                $query->whereMonth('created_at', $month);
            }

            if ($year) {
                $query->whereYear('created_at', $year);
            }

            $reportData = $query->get()->map(function ($item) {
                $monthName = Carbon::create()->month($item->month)->format('F'); // Nome do mês
                return [
                    'date' => $monthName . ' ' . $item->year,
                    'profit' => $item->profit,
                ];
            });
        } elseif ($period == 'daily') {
            $query->selectRaw('DATE(created_at) as date')
                ->groupBy('date');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $reportData = $query->get()->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('d/m/Y'), // Formatar data
                    'profit' => $item->profit,
                ];
            });
        } elseif ($period == 'weekly') {
            $query->selectRaw('YEAR(created_at) as year, WEEK(created_at) as week')
                ->groupBy('year', 'week');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $reportData = $query->get()->map(function ($item) {
                $startOfWeek = Carbon::now()->setISODate($item->year, $item->week, 1);
                $endOfWeek = $startOfWeek->copy()->endOfWeek();
                return [
                    'date' => $startOfWeek->format('d/m/Y') . ' - ' . $endOfWeek->format('d/m/Y'),
                    'profit' => $item->profit,
                ];
            });
        } else {
            Log::error('Invalid period type: ' . $period);
            return response()->json(['error' => 'Invalid period type'], 400);
        }

        // Verificar se existem dados a serem retornados
        if ($reportData->isEmpty()) {
            Log::warning('No data found for the selected period');
            return response()->json(['error' => 'No data found for the selected period'], 404);
        }

        // Logar dados para depuração
        Log::info('Report Data: ', $reportData->toArray());

        return response()->json($reportData);
    }

    /**
     * Verifica a senha e processa o relatório bruto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processarRelatorioBruto(Request $request)
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        $userId = Auth::id();
        $controle = Controle::where('user_id', $userId)->first();

        // Verificar se o controle exige senha para relatórios brutos
        if ($controle && $controle->relatorio_bruto == 1) {
            $request->validate([
                'senha' => 'required|string',
            ]);

            $senha = $request->input('senha');

            // Verificar se a senha está correta
            if (Hash::check($senha, $controle->senha)) {
                return response()->json(['success' => 'Senha correta.'], 200);
            } else {
                return response()->json(['error' => 'Senha incorreta.'], 403);
            }
        }

        return response()->json(['error' => 'Controle de acesso não encontrado.'], 404);
    }

    /**
     * Verifica a senha e processa o relatório de lucro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processarRelatorioLucro(Request $request)
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        $userId = Auth::id();
        $controle = Controle::where('user_id', $userId)->first();

        // Verificar se o controle exige senha para relatórios de lucro
        if ($controle && $controle->relatorio_lucro == 1) {
            $request->validate([
                'senha' => 'required|string',
            ]);

            $senha = $request->input('senha');

            // Verificar se a senha está correta
            if (Hash::check($senha, $controle->senha)) {
                return response()->json(['success' => 'Senha correta.'], 200);
            } else {
                return response()->json(['error' => 'Senha incorreta.'], 403);
            }
        }

        return response()->json(['error' => 'Controle de acesso não encontrado.'], 404);
    }
}
