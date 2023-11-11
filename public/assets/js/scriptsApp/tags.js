$(function() {

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
    
});

function Cargar()
{
    let table = $('#tags-table').DataTable();
    table.ajax.reload();
}


// Función para guardar los datos mediante AJAX
function regStd()
{
    $('#myModal').modal();
    $('#exampleModalLabel').html('Nueva tarea');

     // LIMPIAR CAMPOS
    $('#name').val('');
    $('#description').val('');
    $('#expirated_at').val('');
    
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
    $('#name').val('');
    $('#description').val('');

    $.get("showtgl/"+ btn, (response) => {

            let std = response.tags;

            $('#name').val(std.name);
            $('#description').val(std.description);

    });
    // FIN LIMPIAR CAMPOS

    let u = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'+
            '<button id="editar" class="btn btn-warning" onclick="updateStd('+btn+')">Editar</button>';

    $(".modal-footer").html(u);

}

// Register Task
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
       
    })
    .catch(error => {
         // handle error
        console.log(error);
    });

}

// Eliminar tarea
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
           
        })
        .catch(error => {
             // handle error
            console.log(error);
        });
    }
}