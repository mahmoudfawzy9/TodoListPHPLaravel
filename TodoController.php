<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Validator, Input, Redirect; 
use App\Http\Requests\TodoCreateRequest;
use App\Models\Step;

class TodoController extends Controller
{
  
  public function __construct()
  {
     $this->middleware('auth');
  }
   //
    public function index()
  {
       $todos= auth()->user()->todos()->orderBy('completed')->get();
      return view('todos.index', compact('todos'));
  }

  public function create()
 {
    return view('todos.create');
 }

 public function store(TodoCreateRequest $request)
 {
       $todo= auth()->user()->todos()->create($request->all());
       if($request->step){
        foreach ($request->step as $step ) {
           $todo->steps()->create(['name' => $step]);
        }
     }
     return redirect(route('todo.index'))->with('message', 'Todo created successfully');
 }

 public function show(Todo $todo)
 {
    return view('todos.show',compact('todo'));
 }

 public function edit(Todo $todo)
 {
    return view('todos.edit',compact('todo'));
 }

 public function update(TodoCreateRequest $request, Todo $todo)
 {
    $todo->update(['title'=>$request->title]);

    if($request->stepName){
      foreach ($request->stepName as $key => $value ) {
         $id=  $request->stepId[$key];
    
         if(!$id){
            $todo->steps()->create(['name'=>$value]);
         }else{
            $step = Step::find($id);
            $step->update(['name' => $value]);

         }
      }
   }
   return redirect(route('todo.index'))->with('message', 'Updated!');
  }

 public function complete(Todo $todo)
 {
    $todo->update(['completed'=>true]);
    return redirect()->back()->with('message','Task Marked as completed!');
 }

 public function inComplete(Todo $todo)
 {
    $todo->update(['completed'=>false]);
    return redirect()->back()->with('message','Task Marked as Incompleted!');
 }

 public function destroy(Todo $todo)
 {
    $todo->steps->each->delete();
    $todo->delete();
    return redirect()->back()->with('message','Task deleted!');
 }
}
