@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Produkt</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Produkt {{ $product->id }}</div>
                        <div class="panel-body">
                            <table class="item show data">
                                <tbody>
                                <tr>
                                    <td>Kod producenta:</td>
                                    <td>{{ $product->code }}</td>
                                </tr>
                                <tr>
                                    <td>Nazwa:</td>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <td>Opis:</td>
                                    <td>{{ $product->text }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
            @isset($product)
                <div class="col-xs-12">
                    <h1 class="page-header">Linki dla {{ $product->code }}:</h1>
                    @include('panel.link.section.table', ['route' => route('api.product.link', ['product' => $product->id])])
                </div>
            @endisset
            </div>
        </div>
    </div>
@endsection
