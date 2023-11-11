@extends('layouts.app')

@section('title', 'Tareas')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tareas</h6>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="regStd()" >
            <i class="fas fa-plus fa-sm text-white-50"></i> Crear tarea
        </button>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered text-center" id="task-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="6">Lista de tareas</th>
                    </tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha creación</th>
                    <th>Fecha vencimiento</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
        
    </div>
</div>

@include('tasks.modal')

@endsection

@push('styles')
    <!-- Style Datatables -->
    <link href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <!-- Datatables -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/scriptsApp/tasks.js') }}" type="text/javascript"></script>
@endpush
