@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <ol class="breadcrumb panel-heading">
                    <li class="active">Livros</li>
                </ol>
                <div class="panel-body">
                    <form class="form-inline" action="{{ route('book.search') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group" style="float: right;">
                            <p><a href="{{route('book.add')}}" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i> Adicionar</a></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Livros">
                        </div>
                        <div class="form-group" style="width: 200px; max-width: 200px;">
                            <select name="author[]" class="form-control selectpicker" multiple="" data-live-search="true" title="Author">
                                <?php 
                                if(!empty($authors)){
                                    foreach($authors as $author){ ?>
                                        <option value="<?= $author->id ?>" <?= in_array($author->id, $selecionar_author) ? "selected" : NULL ; ?>><?= $author->name ?></option>
                                <?php }
                            } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                    </form>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Image</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <th scope="row" class="text-center">{{ $book->id }}</th>
                                    <td>{{ $book->title }}</td>
                                    <td class="text-justify">{{ $book->description }}</td>
                                    <td class="form-group">
                                        <img src="/images/book/{{ $book->image }}"  width="10%" />
                                    </td>
                                    <td width="155" class="text-center">
                                        <a href="{{route('book.edit', $book->id)}}" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <a href="{{route('book.delete', $book->id)}}" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection