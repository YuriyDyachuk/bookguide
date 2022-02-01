@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Просмотр автора</h1>
        <ul class="list-group col-md-6 text-center">
            <li class="list-group-item">Фамилия: {{$author->surname}}</li>
            <li class="list-group-item">Имя: {{$author->name}}</li>
            @if(isset($author->patronymic))
                <li class="list-group-item">Отчетсво: {{$author->patronymic}}</li>
            @endif
        </ul>
    </div>
@endsection


