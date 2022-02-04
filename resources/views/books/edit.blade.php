@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="page-container">
            <div class="col-md-12">
                @include('layouts.errors')
                <div class="content" id="formEdit">
                    <!-- Content Header (Page header) -->
                    <section class="content-header text-center col-md-12">
                        <h1 class="col-md-6">Edit book - {{$book->name}}</h1>
                    </section>
                    <hr>
                    &nbsp
                    <!-- Main content -->
                    <form action="{{route('book.update', $book->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <!-- Default box -->
                        <div class="box">
                            <div class="box-body">
                                <div class="col-md-10" style="margin: auto">

                                    @if(!is_null($media))
                                    <div class="row">
                                        <div class="col">
                                            <div class="picture">
                                                <img class="media" src="{{ $media->getUrl() }}" alt="picture">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control"
                                                       value="{{$book->name}}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input type="text" name="description" class="form-control"
                                                       value="{{$book->description}}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Published</label>
                                                <input type="date" name="published" class="form-control"
                                                       value="{{$book->published}}">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    &nbsp;
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Select author</label>
                                                    <select id="multiple_author" name="authors[]" multiple>
                                                        @foreach($authors as $key => $author)
                                                            <option value="{{$key}}">{{$author}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <label>Book author</label>
                                                <div class="form-control">
                                                    @if(!$book->authors->isEmpty())
                                                        @foreach($book->authors as $author)
                                                            <span class="author_detach">{{$author->name}} |
                                                            <a href="{{ route('book.author.detach', ['bookId' => $book->id, 'authorId' => $author->id]) }}">
                                                                 <i class="fas fa-times"></i>
                                                            </a>
                                                        </span>
                                                        @endforeach
                                                    @else
                                                        <span>No author</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="file" name="media" placeholder="Choose File" id="media">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer" style="text-align: center;margin-top: 50px;">
                                <a href="{{ route('books.index') }}" class="btn button-cancel"><span>Cancel<i
                                            class="fas fa-times"></i></span></a>
                                <button type="submit" class="btn button-style1">Edit book<i class="fas fa-book"></i></button>
                            </div>
                            <!-- /.box-footer-->
                        </div>
                        <!-- /.box -->


                    </form>
                    <!-- main content -->
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let multipleAuthor = new Choices('#multiple_author', {
            removeItemButton: true
        });
    </script>
@endpush
