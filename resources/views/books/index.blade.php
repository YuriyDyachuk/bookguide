@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Список книг</h1>
    <div class='row'>
        <div class="col-md-3">
            <input class="form-control" type="text" id="search" name="search" value="" placeholder="Search">
        </div>
        <div class="col-xs-12 col-sm-8 col-md-push-4">
            <button type="button" class="btn btn-primary btn-xs pull-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Добавить книгу
            </button>
        </div>
    </div>
    <br />

    <div class='row @if(!$books->count()) hidden @else show @endif' id='book-wrap'>
        <table class="table table-striped ">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Публикация</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->name }}</td>
                    <td>{{ $book->description }}</td>
                    <td>{{ $book->published->format('Y-m-d') }}</td>
                    <td>
                        <a href=" {{ route('book.show', ['bookId' => $book->id]) }} "><i class="fas fa-eye"></i></a>
                        <a href=" {{ route('book.show', ['bookId' => $book->id]) }} "><i class="fas fa-edit"></i></a>
                        <a href="" class="delete" data-href="{{ route('book.destroy', $book->id) }}"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="alert alert-warning @if(!$books->count()) hidden @else show @endif" role="alert"> Записей нет</div>
    </div>

    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addBookLabel">Добавление книги</h4>
            </div>
            <form method="post" role="form" id="newModalForm" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Описание</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="text">Публикация</label>
                        <input type="date" class="form-control" id="published" name="published">
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" name="media" placeholder="Choose File" id="media">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="save" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(function() {

            /* Save book */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $('#newModalForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type:'POST',
                    url: '{{ url('books') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        if (data) {
                            $('#exampleModal').modal('hide');
                            $('#book-wrap').removeClass('hidden').addClass('show');
                            $('.alert').removeClass('show').addClass('hidden');

                            let book = data.data;
                            let str = '<tr>' +
                                '<td>'+book['id']+'</td>'+
                                '<td>'+book['name']+'</a>'+'</td>'+
                                '<td>'+book['description']+'</a>'+'</td>'+
                                '<td>'+book['published']+'</a>'+'</td>'+
                                '<td><a href="/book/'+book['id']+'" class="show" data-show="'+book['id']+'"><i class="fas fa-eye"></i></a>'+
                                '<a href="/book/'+book['id']+'" class="edit" data-edit="'+book['id']+'"><i class="fas fa-edit"></i></a>'+
                                '<a href="/book/'+book['id']+'" class="delete" data-delete="'+book['id']+'"><i class="fas fa-trash"></i></a></td></tr>';
                            $('.table > tbody:last').append(str);
                        }
                    },
                    error: function(response){
                        console.log(response);
                        // $('#image-input-error').text(response.responseJSON.errors.file);
                    }
                });
            });

            /* Delete book */
            $('body').on('click','.delete', function(e){
                e.preventDefault();
                let url = $(this).data('href');
                let el = $(this).parents('tr');

                $.ajax({
                    url: url,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        el.detach();
                    },
                    error: function (msg) {
                        console.warn('Ошибка');
                    }
                });
            });
        })
    </script>
@endpush
