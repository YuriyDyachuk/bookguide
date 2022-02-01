@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Список авторов</h1>
    <div class='row'>
        <div class="col-md-3">
            <input class="form-control" type="text" id="search" name="search" value="" placeholder="Search">
        </div>
        <div class="col-xs-12 col-sm-8 col-md-push-4">
            <button type="button" class="btn btn-primary btn-xs pull-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Добавить автора
            </button>
        </div>
    </div>
    <br />

    <div class='row @if(!$authors->count()) hidden @else show @endif' id='author-wrap'>
        <table class="table table-striped ">
            <thead>
            <tr>
                <th>ID</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->surname }}</td>
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->patronymic }}</td>
                    <td>
                        <a href=" {{ route('author.show', ['authorId' => $author->id]) }} "><i class="fas fa-eye"></i></a>
                        <a href=" {{ route('author.show', ['authorId' => $author->id]) }} "><i class="fas fa-edit"></i></a>
                        <a href="" class="delete" data-href=" {{ route('author.destroy', $author->id) }} "><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="alert alert-warning @if(!$authors->count()) hidden @else show @endif" role="alert"> Записей нет</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addAuthorLabel">Добавление автора</h4>
            </div>
            <form role="form" id="newModalForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Фамилия</label>
                        <input type="text" class="form-control" id="surname" name="surname" required>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="text">Отчество</label>
                        <input type="text" class="form-control" id="patronymic" name="patronymic">
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

            /* Save author */
            $('#save').on('click',function(e){
                e.preventDefault();
                let surname = $('#surname').val();
                let name = $('#name').val();
                let patronymic = $('#patronymic').val();

                $("#newModalForm").validate({
                    rules: {
                        surname: {
                            required: true,
                            minlength: 3,
                            maxlength: 30,
                        },
                        name: {
                            required: true,
                            minlength: 2,
                            maxlength: 20,
                        },
                        action: "required",
                    },
                    messages: {
                        surname: {
                            required:  '<span class="error_form">Поле обязательно к заполнению</span>' ,
                            minlength: '<span class="error_form">Минимальное значение - 3 символа</span>',
                            maxlength: '<span class="error_form">Максимальное значение - 30 символ</span>'
                        },
                        name: {
                            required:  '<span class="error_form">Поле обязательно к заполнению</span>' ,
                            minlength: '<span class="error_form">Минимальное значение - 2 символа</span>',
                            maxlength: '<span class="error_form">Максимальное значение - 20 символ</span>'
                        }
                    }
                });

                $.ajax({
                    url: '{{ url('authors') }}',
                    type: "POST",
                    data: {surname,name,patronymic},
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $('#exampleModal').modal('hide');
                        $('#author-wrap').removeClass('hidden').addClass('show');
                        $('.alert').removeClass('show').addClass('hidden');

                        let author = data.data;
                        let str = '<tr>' +
                            '<td>'+author['id']+'</td>'+
                            '<td><a href="/author/'+author['id']+'">'+author['surname']+'</a>'+'</td>'+
                            '<td><a href="/author/'+author['id']+'">'+author['name']+'</a>'+'</td>'+
                            '<td><a href="/author/'+author['id']+'">'+author['patronymic']+'</a>'+'</td>'+
                            '<td><a href="/author/'+author['id']+'" class="show" data-show="'+author['id']+'">Просмотр</a>'+
                            '<a href="/author/'+author['id']+'" class="edit" data-edit="'+author['id']+'">Редактировать</a>'+
                            '<a href="/author/'+author['id']+'" class="delete" data-delete="'+author['id']+'">Удалить</a></td></tr>';
                        $('.table > tbody:last').append(str);
                    },
                    error: function (msg) {
                        console.warn('Ошибка');
                    }
                });

            });

            /* Delete author */
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
