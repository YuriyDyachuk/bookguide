@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="page-container">
            <div class="col-md-12">
                @include('layouts.errors')
                <div class="content" id="formEdit">
                    <!-- Content Header (Page header) -->
                    <section class="content-header text-center col-md-12">
                        <h1 class="col-md-6">Edit author - {{$author->name}}</h1>
                    </section>
                    <hr>
                    &nbsp
                    <!-- Main content -->
                    <form action="{{route('author.update', $author->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <!-- Default box -->
                        <div class="box">
                            <div class="box-body">
                                <div class="col-md-10" style="margin: auto">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Surname</label>
                                                <input type="text" name="surname" class="form-control"
                                                       value="{{$author->surname}}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control"
                                                       value="{{$author->name}}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Patronymic</label>
                                                <input type="text" name="patronymic" class="form-control"
                                                       value="{{$author->patronymic}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer" style="text-align: center;margin-top: 50px;">
                                <a href="{{ route('authors.index') }}" class="btn button-cancel"><span>Cancel<i
                                            class="fas fa-times"></i></span></a>
                                <button type="submit" class="btn button-style1">Edit author<i
                                        class="fas fa-user-edit"></i></button>
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
@endpush
