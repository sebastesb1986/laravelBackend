$(() => {

    // contenido Datatables 
    $('#task-table').DataTable({
        "language": {
                "url": "/assets/js/spanish.json"
        },
        processing: false,
        responsive: true,
        serverSide: true,
        ajax: 'tk',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'name', name: 'name'},
            { data: 'description', name: 'description'},
            { data: 'created_at', name: 'created_at'},
            { data: 'expirated_at', name: 'expirated_at'},
            { data: 'user', name: 'user'},
            { data: 'details', name: 'details'},
        ],
        order: [[ 1, "asc" ]],
        pageLength: 8,
        lengthMenu: [2, 4, 6, 8, 10],
    });

    // Datepicker configuración fecha de caducidad
    $('.datepicker').attr('readonly', true);

    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        orientation: "top right",
        autoclose: true,
        startDate: '-1d'
    }).on('show', function(e) {

        let dateValue = $(this).val();
        
        // Si no hay fecha seleccionada, establecer la fecha actual
        $(this).datepicker('setDate', new Date());

        if (dateValue) {
            let date = new Date(dateValue + "T00:00:00");
            $(this).datepicker('setDate', date);
        }
    })

    // Toast para validacioens
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    
    
});

// Refresh Datatable
function Cargar()
{
    let table = $('#task-table').DataTable();
    table.ajax.reload();
}

// Limpiar inputs
function cleanInput(btn){

    const bool = (btn == null) ? false : true;

    $('#name').val('').attr('disabled', bool);
    $('#description').val('').attr('disabled', bool);
    $('#expirated_at').val('').attr('disabled', bool);
    $('#user_id').val(null).trigger('change').attr('disabled', bool);
    $('#tags').html('').attr('disabled', bool);

}

// Lista de usuarios
$("#user_id").select2({
    width: '100%',
    placeholder: 'Seleccione...',
    language: {
        noResults: function () {
            return "No hay resultado";
        },
        searching: function () {
            return "Buscando..";
        }
    },
    ajax: {
        url: 'userList',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            let cnt = data.users;
            let auth = data.auth;
        
            // Guarda la referencia al elemento select2
            let $select2 = $("#user_id");
        
            // Limpia las opciones existentes
            $select2.empty();
        
            // Agrega una opción para el usuario autenticado
            $select2.append(new Option(auth.name, auth.id, true, true));
        
            // Mapeo de los resultados
            let results = $.map(cnt, (item) => {
                return {
                    text: item.name,
                    id: item.id
                };
            });
        
            // Agrega el resto de las opciones
            results.forEach((item) => {
                $select2.append(new Option(item.text, item.id, false, false));
            });
        
            // Inicializa Select2 nuevamente
            $select2.trigger('change');
        
            return {
                results: results
            };
        }
        ,
        cache: true
    }
});

// Lista de etiquetas
$("#tags").select2({
    width: '100%',
    placeholder: 'Seleccione...',
    language: {
        noResults: function () {
            return "No hay resultado";
        },
        searching: function () {
            return "Buscando..";
        }
    },
    ajax: {
        url: 'tagsList',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {

            let cnt = data.tags;
            
            return {
                results: $.map(cnt, (item) => {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    }
});

// Mostrar tarea según su Id
function showCustomTask(btn){

    $.get("showtk/"+ btn, (response) => {

        let std = response.task;
        let tgs = std.tags;

        $('#name').val(std.name);
        $('#description').val(std.description)
        $('#expirated_at').val(std.expirated_at)
        $("#user_id").html(`<option value=${std.users.id}>${std.users.name}</option>`)

         // Llenar el select de tags con múltiples opciones
         tgs.forEach(tag => {

            let option = new Option(tag.name, tag.pivot.tags_id, true, true); // Crear una nueva opción
            $('#tags').append(option); // Agregar la opción al select
        
            // Enviar los datos de las etiquetas a la vista
            $('#tags').trigger('change');
        });
        
        // Actualizar etiquetas en la vista
        $('#tags').trigger('change');

    });

}

// Ver, Registrar y actualizar tarea en ventana modal
function showStd(btn)
{
    $('#myModal').modal();
    $('#exampleModalLabel').html("<b>Detalles tarea</b>");

    // LIMPIAR CAMPOS
    cleanInput(btn);

    showCustomTask(btn);
    // FIN LIMPIAR CAMPOS

    let u = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';

    $(".modal-footer").html(u);

}

function regStd()
{
    $('#myModal').modal();
    $('#exampleModalLabel').html('Nueva tarea');

     // LIMPIAR CAMPOS
    cleanInput();
    
    // FIN LIMPIAR CAMPOS

    let r = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'+
            '<button id="registro" class="btn btn-primary" onclick="registerStd()" >Agregar</button>';
            
    $(".modal-footer").html(r);

}

function upStd(btn)
{
    $('#myModal').modal();
    $('#exampleModalLabel').html('Modificar tarea');

    // LIMPIAR CAMPOS
    cleanInput();

    showCustomTask(btn);
    // FIN LIMPIAR CAMPOS

    let u = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'+
            '<button id="editar" class="btn btn-dark" onclick="updateStd('+btn+')">Editar</button>';

    $(".modal-footer").html(u);

}

// Register, update and delete Task with AJAX
function registerStd()
{
    let route = 'createtk';

    let ajax_data = {

        name: $('#name').val(),
        description: $('#description').val(),
        expirated_at: $('#expirated_at').val(),
        user_id: $('#user_id').val(),
        tags: $('#tags').val(),

    };

    $.ajax({
        url: route,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        dataType: 'json',
        data: ajax_data,
    }).then(response => {

        Cargar();
        $('#myModal').modal('toggle');
        toastr.success(response.message);
                 
    })
    .catch(e => {

        const arr = e.responseJSON;
        const toast = arr.errors;
    
        if (e.status == 422) {
            if (toast.name != null) toastr.error(toast.name[0]);
            if (toast.description != null) toastr.error(toast.description[0]);
            if (toast.expirated_at != null) toastr.error(toast.expirated_at[0]);
            if (toast.user_id != null) toastr.error(toast.user_id[0]);
        }

    });
    

}

function updateStd(btn)
{  
    $('#myModal').modal();
   
    let route = "updatetk/"+btn;

    let ajax_data = {

        name: $('#name').val(),
        description: $('#description').val(),
        expirated_at: $('#expirated_at').val(),
        user_id: $('#user_id').val(),
        tags: $('#tags').val(),

    };

    $.ajax({
        url: route,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'X-HTTP-Method-Override': 'PUT' },
        type: 'POST',
        dataType: 'json',
        data: ajax_data,
    }).then(response => {
    
        Cargar();
        $('#myModal').modal('toggle');
        toastr.success(response.message);

    })
    .catch(e => {
         
        const arr = e.responseJSON;
        const toast = arr.errors;
    
        if (e.status == 422) {

            if (toast.name != null) toastr.error(toast.name[0]);
            if (toast.description != null) toastr.error(toast.description[0]);
            if (toast.expirated_at != null) toastr.error(toast.expirated_at[0]);
            if (toast.user_id != null) toastr.error(toast.user_id[0]);
        }

        else if(e.status == 403){

            $('#myModal').modal('toggle');
            toastr.warning(arr.error);

        }

    });

}

function deleteStd(btn){

    let route = "deletetk/"+btn;
    
    let conf  = confirm('¿Desea Eliminar la tarea de la lista?');
    if(conf){
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: 'DELETE',
            dataType: 'json',
        }).then(response => {

            Cargar();
            $('#task-table').DataTable().ajax.reload();
            toastr.success(response.success);
           
        })
        .catch(e => {
             
            const arr = e.responseJSON;
          
             if(e.status == 403){

                toastr.warning(arr.error);
              
             }
        });
    }
}

  