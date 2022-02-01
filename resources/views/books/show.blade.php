@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Просмотр книги</h1>
        <ul class="list-group col-md-6 text-center">
            <li class="list-group-item">Название: {{$book->name}}</li>
            <li class="list-group-item">Описание: {{$book->description}}</li>
            <li class="list-group-item">Публикация: {{$book->published->format('Y-m-d')}}</li>
        </ul>
    </div>
@endsection


