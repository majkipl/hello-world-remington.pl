@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Link</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Link {{ $link->id }}</div>
                        <div class="panel-body">
                            <table class="item show data">
                                <tbody>
                                <tr>
                                    <td>URL:</td>
                                    <td>{{ $link->url }}</td>
                                </tr>
                                <tr>
                                    <td>Kod produktu:</td>
                                    <td>{{ $link->product->code }}</td>
                                </tr>
                                <tr>
                                    <td>Nazwa produktu:</td>
                                    <td>{{ $link->product->name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
