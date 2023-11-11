$(function() {

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
    
});

function Cargar()
{
    let table = $('#task-table').DataTable();
    table.ajax.reload();
}

// Limpiar inputs
function cleanDisableInput(){

    $('#name').val('').attr('disabled', true);
    $('#description').val('').attr('disabled', true);
    $('#expirated_at').val('').attr('disabled', true);
    $('#user_id').val(null).trigger('change').attr('disabled', true);
    $('#tags').html('').attr('disabled', true);

}

function cleanInput(){

    $('#name').val('').attr('disabled', false);
    $('#description').val('').attr('disabled', false);
    $('#expirated_at').val('').attr('disabled', false);
    $('#user_id').val(null).trigger('change').attr('disabled', false);
    $('#tags').html('').attr('disabled', false);

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

// Ver tarea
function showStd(btn)
{
    $('#myModal').modal();
    $('#exampleModalLabel').html("<b>Detalles tarea</b>");

    // LIMPIAR CAMPOS
    cleanDisableInput();

    $.get("showtk/"+ btn, (response) => {

            let std = response.task;
            let tgs = response.tags;

           

            $('#name').val(std.name);
            $('#description').val(std.description)
            $('#expirated_at').val(std.expirated_at)
            $("#user_id").html(`<option value=${std.users.id}>${std.users.name}</option>`)

             // Llenar el select de tags con múltiples opciones
             tgs.forEach(tag => {
                let option = new Option(tag.name, tag.id, true, true); // Crear una nueva opción
                $('#tags').append(option); // Agregar la opción al select
            
                // Enviar los datos de las etiquetas a la vista
                $('#tags').trigger('change');
            });
            
            // Actualizar etiquetas en la vista
            $('#tags').trigger('change');

    });
    // FIN LIMPIAR CAMPOS

    let u = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';

    $(".modal-footer").html(u);

}

// Función para guardar los datos mediante AJAX
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

    $.get("showtk/"+ btn, (response) => {

            let std = response.task;
            let tgs = response.tags;

            $('#name').val(std.name);
            $('#description').val(std.description);
            $('#expirated_at').val(std.expirated_at);
            $("#user_id").html(`<option value=${std.users.id}>${std.users.name}</option>`);

             // Llenar el select de tags con múltiples opciones
             tgs.forEach(tag => {
                let option = new Option(tag.name, tag.id, true, true); // Crear una nueva opción
                $('#tags').append(option); // Agregar la opción al select
            
                // Enviar los datos de las etiquetas a la vista
                $('#tags').trigger('change');
            });
            
            // Actualizar etiquetas en la vista
            $('#tags').trigger('change');

    });
    // FIN LIMPIAR CAMPOS

    let u = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'+
            '<button id="editar" class="btn btn-warning" onclick="updateStd('+btn+')">Editar</button>';

    $(".modal-footer").html(u);

}

// Register Task
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
            
        
        
    })
    .catch(error => {
        // handle error
        console.log(error.status);
    });

}

// Update Task
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
       
    })
    .catch(error => {
         // handle error
         if(error.status == 403){

            $('#myModal').modal('toggle');
         }
    });

}

// Eliminar tarea
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
           
        })
        .catch(error => {
             // handle error
             if(error.status == 403){

              alert("No puedes eliminar esta tarea, no te pertenece");
              
             }
        });
    }
}