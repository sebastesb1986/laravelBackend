@extends('layouts.app')

@section('title', 'Tareas')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="regStd()" >
            <i class="fas fa-plus fa-sm text-white-50"></i> Crear Tarea
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
    <link href="{{ asset('assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .select2-selection__choice {
        height: 25px;
        line-height: 25px;
        padding-right: 12px !important;
        padding-left: 12px !important;
        background-color: #5897FB !important;
        color: #FFF !important;
        border: none !important;
        border-radius: 3px !important;
        }
        .select2-selection__choice__remove {
            float: left;
            margin-right: 2px;
            margin-left: 0px;
            color: #FFF !important;
        }
    </style>
@endpush

@push('scripts')
    <!-- Datatables -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/scriptsApp/tasks.js') }}" type="text/javascript"></script>
@endpush
