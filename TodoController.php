<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Validator, Input, Redirect; 
use App\Http\Requests\TodoCreateRequest;
use App\Models\Step;
// use App\Http\Livewire\Step;

class TodoController extends Controller
{
  
  public function __construct()
  {
     $this->middleware('auth');
  }
   //
    public function index()
  {
      //   $todos = Todo::all();
       $todos= auth()->user()->todos()->orderBy('completed')->get();
      //  return $todos;
      //   $todos = Todo::orderBy('completed')->get();

      //   return $todos;
      return view('todos.index', compact('todos'));
      // return view('todos.index')->with(['todos'=>$todos]);
  }

  public function create()
 {
    return view('todos.create');
 }

 public function store(TodoCreateRequest $request)
 {
    // $rules=[
    //     'title' => 'required|max:255',
    // ];

    // $messages=[
    //     'title.max' => 'TODO title should not be greater than 255 chars.',
    // ];

    // $validator = Validator::make($request->all(), $rules, $messages);
    // if ($validator->fails()) {
    //     return redirect()->back()
    //                 ->withErrors($validator)
    //                 ->withInput();
    // }

    //  $request->validate([
    //   'title' => 'required|max:255'
    //  ]);
   //  $userId = auth()->id();
   //  $request['user_id']= $userId;
      // dd($request->all());
   //   auth()->user()->todos()->create($request->all());
   //   $userId = (auth()->id());
   //   $request['user_id'] = $userId;
      // $stepName = $request->input('name');
      // $stepId = $request->input('name');
       $todo= auth()->user()->todos()->create($request->all());
      //  $todo->steps()->create();
       if($request->step){
        foreach ($request->step as $step ) {
           $todo->steps()->create(['name' => $step]);
        }
     }
      // dd($todo);
     return redirect(route('todo.index'))->with('message', 'Todo created successfully');
   //   return redirect()->back()->with('message', 'Todo created successfully');

 }

 public function show(Todo $todo)
 {
   //  return $todo->steps;
   // return $todo->steps()->count();
    return view('todos.show',compact('todo'));
 }

 public function edit(Todo $todo)
 {
      //  dd($todo->description);
   //   dd($id->title);
   // //  return $todo;
   //    $todo = auth()->user()->todos()->find($id);
   //    // $todo = Todo::find($id);
    return view('todos.edit',compact('todo'));
 }

 public function update(TodoCreateRequest $request, Todo $todo)
 {
    $todo->update(['title'=>$request->title]);
   //   dd($request->all());

    if($request->stepName){
      foreach ($request->stepName as $key => $value ) {
         // dd($step);
         $id=  $request->stepId[$key];
         // dd($key);
         // dd($request->stepId[$key]);
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
