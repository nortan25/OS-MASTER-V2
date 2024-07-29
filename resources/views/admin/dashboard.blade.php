@extends('layouts.bar2')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total de Usuários Registrados</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalUsers }}</h5>
                    <p class="card-text">Este é o número total de usuários registrados na plataforma.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total de Ordens</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalOrdens }}</h5>
                    <p class="card-text">Este é o número total de ordens realizadas no sistema.</p>
                </div>
            </div>
        </div>
    </div>
</div>



    



@include('admin.notificacao-entrada') <!-- Inclui o modal de notificação -->
@endsection
