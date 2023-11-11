<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Tags;

class TagsController extends Controller
{
    // 0. Lista etiquetas
    public function tagsList()
    {
        $tags = Tags::select('id', 'name')->get();

        return response()->json(['tags' => $tags]);

    }

     // 1. Mostrar las etiquetas existentes
     public function index(Request $request){

        $tags = Tags::select('id', 'name', 'description')
                    ->get();

        if ($request->ajax()) {

            return Datatables::of($tags)
            ->addIndexColumn()
            ->addColumn('details', function ($td) {

                $href = '<button type="button" class="btn btn-warning btn-circle btn-sm" onclick="upStd('.$td->id.')" data-toggle="tooltip" data-placement="top" title="Modificar etiqueta"><i class="fas fa-pencil-alt"></i></button>&nbsp';
                
                $href .= '<button type="button" class="btn btn-danger btn-circle btn-sm" onclick="deleteStd('.$td->id.')" data-toggle="tooltip" data-placement="top" title="Quitar etiqueta"><i class="fas fa-trash"></i></button>';

                return $href;
                
             })
            ->rawColumns(['details'])
            ->make(true);

        }

        return view('tags.index');

    }

     // 2. Mostrar tarea
     public function show($id)
     {
         $tags = Tags::findOrFail($id);
         
         return response()->json([ 'tags' => $tags ]);
 
     }

    // 3. Crear etiquetas
    public function store(Request $request)
    {
        // Datos obtenidos desde la interfaz para crear la etiqueta
        $data = [

            'name' => $request->name, 
            'description' => $request->description,  

        ];

        // Crear etiqueta
        $created = Tags::create($data);

        // Comprobar que la etiqueta ha sido creada
        if($created){

            // Registrar etiquetas
            return response()->json(['message' => 'Etiqueta creada correctamente'], 200);
            
        }
       

    }

     // 4. Actualizar etiqueta
     public function update(Request $request, $id)
     {
         // Obtener etiqueta a actualizar
         $tags = Tags::findOrFail($id);
         // Datos obtenidos desde la interfaz para crear etiqueta
         $data = [
 
             'name' => $request->name, 
             'description' => $request->description,  
 
         ];
       
         // Crear etiqueta
         $update = $tags->update($data);
 
         // Comprobar que la etiqueta ha sido actualizada
         if($update){
  
             return response()->json(['message' => 'Etiqueta actualizada exitosamente'], 200);
         }
        
 
     }
 
     //5. eliminar etiqueta
     public function delete($id)
     {
         $tags = Tags::findOrFail($id);
       
         $delete = $tags->delete();
         
         if($delete){
 
             return response()->json(['success'=>'Etiqueta eliminada exitosamente'], 200);
 
         }
     }

}
