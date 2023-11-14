<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    // 1. Mostrar las tareas existentes
    public function index(Request $request){

        $tasks = Task::with(['users' => function($td){
                        $td->select(['id', 'name', 'email']);
                    }])
                    ->select('id', 'name', 'description', 'created_at', 'expirated_at', 'user_id')
                    ->get();

        if ($request->ajax()) {

            return Datatables::of($tasks)
            ->addIndexColumn()
            ->addColumn('user', function ($td) {

                $href = $td->users->name;
                return $href;
                
             })
            ->addColumn('details', function ($td) {

                $href = '<button type="button" class="btn btn-primary btn-circle btn-sm" onclick="showStd('.$td->id.')" data-toggle="tooltip" data-placement="top" title="Ver tarea"><i class="fas fa-eye"></i></button>&nbsp';

                if(auth()->user()->can('update', $td)){

                    $href .= '<button type="button" class="btn btn-dark btn-circle btn-sm" onclick="upStd('.$td->id.')" data-toggle="tooltip" data-placement="top" title="Modificar tarea"><i class="fas fa-pencil-alt"></i></button>&nbsp';
                    $href .= '<button type="button" class="btn btn-danger btn-circle btn-sm" onclick="deleteStd('.$td->id.')" data-toggle="tooltip" data-placement="top" title="Quitar tarea"><i class="fas fa-trash"></i></button>';
                
                }

                return $href;
                
             })
            ->rawColumns(['user', 'details'])
            ->make(true);

        }

        return view('tasks.index');

    }

    // 2. Mostrar tarea
    public function show(Request $request, $id)
    {
       
        $task = Task::with(['users' => function($td){
                        $td->select('id', 'name');
                    }])
                    ->with(['tags' => function($query) {
                        $query->select('name');
                    }])
                    ->findOrFail($id);        

        return response()->json([ 'task' => $task ]);

    }

    // 3. Crear tareas
    public function store(TaskRequest $request)
    {
        // Obtener el usuario que ha iniciado sesión
        $user = auth()->user();

        // Datos obtenidos desde la interfaz para crear la tarea
        $data = [

            'name' => $request->name, 
            'description' => $request->description,  
            'expirated_at' => $request->expirated_at,
            'user_id' => $request->user_id

        ];

        // Crear tarea
        $created = Task::create($data);

        // Comprobar que la tarea ha sido creada
        if($created){

            // Registrar etiquetas
            $created->tags()->sync($request->tags);

            return response()->json(['message' => 'Tarea creada exitosamente'], 200);
        }
       

    }

    // 4. Actualizar tarea
    public function update(TaskRequest $request, $id)
    {
        // Obtener el usuario que ha iniciado sesión
        $user = auth()->user();

        // Obtener tarea a actualizar
        $task = Task::findOrFail($id);

        $data = [

            'name' => $request->name, 
            'description' => $request->description,  
            'expirated_at' => $request->expirated_at,
            'user_id' => $request->user_id

        ];

        // Politica para no actualizar tareas ajenas a las nuestras
        try {
            // Verifica si el usuario tiene permiso para actualizar la tarea
            $this->authorize('update', $task);

                // Datos obtenidos desde la interfaz para crear la tarea
            // Crear tarea
            $update = $task->update($data);

            // Comprobar que la tarea ha sido creada
            if($update){

                // Registrar etiquetas
                $task->tags()->sync($request->tags);

                return response()->json(['message' => 'Tarea actualizada exitosamente'], 200);
            }
        } catch (AuthorizationException $e) {

            return response()->json(['error' => 'No estás autorizado para realizar esta acción'], 403);

        }

    }

    //5. eliminar tarea
    public function delete($id)
    {
        $task = Task::findOrFail($id);

        try{

            $this->authorize('update', $task);

            $delete = $task->delete();

        
            if($delete){
    
                return response()->json(['success'=>'Tarea eliminada exitosamente'], 200);
    
            }

        }catch (AuthorizationException $e) {

            return response()->json(['error' => 'No estás autorizado para realizar esta acción'], 403);

        }
       
    }


}
