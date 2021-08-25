<?php

namespace App\Http\Controllers;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /* 
    * Add the todo.
    * @response-format json 
    * @param name,description, tag. 
    * @response true on success otherwise error message.
    */
    public function addTodo(Request $request){
        $request->validate([
           'name' =>'required',
           'description'=>'required'
        ]);
        $Todo = new Todo();
        $Todo->name = $request->name;
        $Todo->description = $request->description;
        $Todo->tag = implode(" ",$request->tag);
        /* execute and save record. */ 
        $save = $Todo->save();
        /* execute, if record save. */ 
        if($save){
            return response()->json(['success'=>true]);
        }
        /* execute, if record not save and throw error message. */ 
        else{
            return response()->json(['success'=>false, 'message'=> 'Unable to add todo']);
        }
    }

    /* 
    * fetch the particular todo.
    * @response-format json 
    * @param id . 
    * @response todo in json object on success otherwise error message.
    */
    public function fetchTodoById($id){
        /* it execute to fetch the record. */ 
        $Todo = Todo::find($id);
        /* execute, if record found. */ 
        if($Todo){
            return response()->json(['success'=>true,'result'=> $Todo]);
        }
        /* execute, if record not found and throw error message. */ 
        else{
            return response()->json(['success'=>false, 'message'=> 'Unable to add todo']);
        }
    }
    
    /* 
    * getting all the todo list .
    * @response-format json 
    * @param null 
    * @response todo list(array) on success otherwise error message.
    */
    public function getTodo(){
        /* it execute, to fetch all to-do list. */ 
        $toDoList = Todo::get();
        if($toDoList){
            return response()->json(['success'=>true, 'result'=> $toDoList]);
        }else{
            return response()->json(['success'=>false, 'message'=> 'Unable to fetch todo']);
        }     
    }

    /* 
    * delete the particular todo.
    * @response-format json 
    * @param id. 
    * @response true, if record found and delete return success otherwise error message.
    */
    public function deleteTodo(Request $request){
        /* it execute, to find a to-do record. */ 
        $Todo = Todo::find($request->id);
        /* execute, if record exists. */ 
        if($Todo){
            $Todo->delete();
            return response()->json(['success'=>true]);
        }
        /* execute, if record not exists. throw error message */ 
        else{
            return response()->json(['success'=>false, 'message'=> 'Unable to fetch todo']);
        }
    }
    
     /* 
    * Update the particular todo.
    * @response-format json 
    * @param id, name, description, tag 
    * @response true on success otherwise error message.
    */
    public function updateTodo(Request $request, $id) {
        $request->validate([
           'name' =>'required',
           'description'=>'required'
        ]);
        $Todo = Todo::find($id);
        /* execute, if record found and then further proceed to save the record. */ 
        if($Todo){
            $Todo->name = $request->name;
            $Todo->description = $request->description;
            $Todo->tag = count($request->tag) > 0 ? implode(" ",$request->tag): null;
            $Todo->save();
            return response()->json(['success'=>true]);
        }
        /* execute, if record not found and throw error message. */ 
        else{
            return response()->json(['success'=>false, 'message'=> 'Unable to update todo']);
        }
    }
    
    /* 
    * Mark complete and uncomplete the particular todo.
    * @response-format json 
    * @param id, iscompleted. 
    * @response update iscompleted as per id and return true on success otherwise error message.
    */
    public function completed(Request $request, $id){
       $Todo = Todo::find($id);
       /* execute, if record exist and throw success message. */ 
       if($Todo){
           $Todo->iscompleted = $request->iscompleted;
            $Todo->save();
            return response()->json(['success'=>true]);
       }
       /* execute, if record not exist and throw error message. */ 
       else{
           return response()->json(['success'=>false, 'message'=> 'Unable to update todo']);
       }
    }
    
       /* 
    * checked or unchecked all todos .
    * @response-format json 
    * @param iscompleted 
    * @response update iscompleted status and return true on success otherwise error message.
    */
    public function checkedAll(Request $request){
       /* update all to-dos list. as per iscompleted param values */ 
        if($request->isCheckedAll){
            $Todo = Todo::where('iscompleted',0)->update([
                'iscompleted'=> 1
            ]);
           /* it will execute, if record updated. */ 
            if($Todo){
               return response()->json(['success'=>true]);
            }
            /* execute, if record not update and throw error message. */ 
            else{
                return response()->json(['success'=>false, 'message'=> 'Unable to update todo']);
            }
       }
       /* execute, if record needs to update not iscompleted. */ 
        else{
           $Todo = Todo::where('iscompleted',1)->update([
                'iscompleted'=> 0
            ]);
            /* execute, if record updated and throw success message. */ 
            if($Todo){
               return response()->json(['success'=>true]);
            }
            /* execute, if record not updated and throw error message. */ 
            else{
                return response()->json(['success'=>false, 'message'=> 'Unable to update todo']);
            }
       }
    }
}
?>