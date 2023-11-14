$(()=> {

    // contenido Datatable
    $('#tags-table').DataTable({
        "language": {
                "url": "/assets/js/spanish.json"
        },
        processing: false,
        responsive: true,
        serverSide: true,
        ajax: 'tg',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'name', name: 'name'},
            { data: 'description', name: 'description'},
            { data: 'details', name: 'details'},
        ],
        order: [[ 1, "asc" ]],
        pageLength: 8,
        lengthMenu: [2, 4, 6, 8, 10],
    });

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
    let table = $('#tags-table').DataTable();
    table.ajax.reload();
}

function cleanInput(){

    $('#name').val('').attr('disabled', false);
    $('#description').val('').attr('disabled', false);

}

// Registrar y actualizar tarea en ventana modal
function regStd()
{
    $('#myModal').modal();
    $('#exampleModalLabel').html('Nueva tarea');

    // LIMPIAR CAMPOS
    cleanInput()
    // FIN LIMPIAR CAMPOS

    let r = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'+
            '<button id="registro" class="btn btn-primary" onclick="registerStd()" >Agregar</button>';
            
    $(".modal-footer").html(r);

}

function upStd(btn)
{
    $('#myModal').modal();
    $('#exampleModalLabel').html('Modificar etiqueta');

    // LIMPIAR CAMPOS
    cleanInput()

    $.get("showtgl/"+ btn, (response) => {

            let std = response.tags;

            $('#name').val(std.name);
            $('#description').val(std.description);

    });
    // FIN LIMPIAR CAMPOS

    let u = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'+
            '<button id="editar" class="btn btn-dark" onclick="updateStd('+btn+')">Editar</button>';

    $(".modal-footer").html(u);

}

// Register, update and delete Tags with AJAX
function registerStd()
{
    let route = 'createtg';

    let ajax_data = {

        name: $('#name').val(),
        description: $('#description').val(),
 
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
        }

    });

}

function updateStd(btn)
{  
    $('#myModal').modal();
   
    let route = "updatetg/"+btn;

    let ajax_data = {

        name: $('#name').val(),
        description: $('#description').val(),
 
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
          
        }
        else if(e.status == 403){

            $('#myModal').modal('toggle');
            toastr.warning(arr.error);

        }

    });

}

function deleteStd(btn){

    let route = "deletetg/"+btn;
    
    let conf  = confirm('¿Desea Eliminar la etiqueta de la lista?');
    if(conf){
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: 'DELETE',
            dataType: 'json',
        }).then(response => {

            Cargar();
            $('#tags-table').DataTable().ajax.reload();
            toastr.success(response.success);
           
        })
        .catch(e => {
             
            const arr = e.responseJSON;
            
            toastr.warning(arr.error);
              
    
        });
    }
}