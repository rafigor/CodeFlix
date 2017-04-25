@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Ver Série</h3>
            <div class="row">
                <?php $iconEdit = Icon::create('pencil')?>
                {!! Button::primary($iconEdit)
                        ->asLinkTo(route('admin.series.edit',['series'=>$serie->id])) !!}
                <?php $iconDestroy = Icon::create('remove')?>
                {!! Button::danger($iconDestroy)
                        ->asLinkTo(route('admin.series.destroy',['series'=>$serie->id]))
                        ->addAttributes(['onclick' => "event.preventDefault(); document.getElementById(\"form-delete\").submit();"])
                !!}

                <?php
                $formDelete = FormBuilder::plain([
                    'id' => 'form-delete',
                    'route' => ['admin.series.destroy', 'series' => $serie->id],
                    'method' => 'DELETE',
                    'style' => 'display:none']);
                ?>
                {!! form($formDelete) !!}
                <br/><br/>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row">#</th>
                        <td>{{$serie->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Título</th>
                        <td>{{$serie->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Descrição</th>
                        <td>{{$serie->description}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
