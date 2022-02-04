@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col">
                <div class="picture">
                    <img class="media" src="{{ $media->getUrl() }}" alt="picture">
                </div>
            </div>
        </div>

        <div class="row">
           <div class="col">
               <h1>Просмотр книги</h1>
               <ul class="list-group col-md-10 text-center">
                   <li class="list-group-item">Название: {{$book->name}}</li>
                   <li class="list-group-item">Описание: {{$book->description}}</li>
                   <li class="list-group-item">Публикация: {{$book->published->format('Y-m-d')}}</li>
               </ul>
           </div>
            <div class="col" style="display: flex;align-items: center;">
                <div class="form-control">
                    <label>Author:</label>
                    @if(!$book->authors->isEmpty())
                        @foreach($book->authors as $author)
                            <span class="author_detach">{{$author->name}}</span>
                        @endforeach
                    @else
                        <span>No author</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- /.box-body -->
        <div class="box-footer" style="text-align: center;margin-top: 50px;">
            <a href="{{ route('books.index') }}" class="btn button-cancel"><span>Cancel<i
                        class="fas fa-times"></i></span></a>
        </div>
        <!-- /.box-footer-->

    </div>
@endsection


