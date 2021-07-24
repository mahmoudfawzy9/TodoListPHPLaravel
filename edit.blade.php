
@extends('todos.layout')

@section('content')
<div class="flex justify-between border-b pb-4 px-4">
<h1 class="text-2xl pb-4">Update this Todo list</h1>  
<a href="{{route('todo.index')}}" class="m-5 py-2 text-gray-400 cursor-pointer text-white">
<span class="fas fa-arrow-left" />
      </a>
</div>
          @include('layouts.alert')
    <form method="post" action="{{route('todo.update',$todo->id)}}" class="py-5">
          @csrf
          @method('patch')
          <div class="py-1">
          <input type="text" name="title" value="{{$todo->title}}"
           class="py-2 px-2 border rounded" placeholder="Title" />
          </div>
          <div class="py-1">
                <textarea name="description" class="p-2 rounded border" 
                placeholder="Description">{{$todo->description}}</textarea>
          </div>
          <div >
          @livewire('edit-step',['steps' => $todo->steps])
          </div>
          <div class="py-1">
          <input type="submit" value="Update" class="p-2 border rounded" />
          </div>
     </form>
     <!-- <a href="{{route('todo.index')}}" class="m-5 py-1 px-1 bg-white-400 cursor-pointer rounded">Back</a> -->
     @endsection
