@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Produkt</h1>
                </div>
            </div>
            <form class="form row save" id="saveForm" method="{{ isset($product) ? 'put' : 'post' }}"
                  action="{{ route(isset($product) ? 'api.product.update' : 'api.product.add') }}">
                @csrf
                <div class="row">
                    <x-form.input.text name="code" placeholder="Kod producenta" required max="255" class-wrapper="col-xs-12 col-sm-6 col-sm-offset-3" :value="isset($product) ? $product->code : ''"/>

                    <x-form.input.text name="name" placeholder="Nazwa" required max="255" class-wrapper="col-xs-12 col-sm-6 col-sm-offset-3" :value="isset($product) ? $product->name : ''"/>

                    <x-form.textarea name="text" placeholder="Opis" required max="4096" class-wrapper="col-xs-12 col-sm-6 col-sm-offset-3">
                        {{ isset($product) ? $product->text : '' }}
                    </x-form.textarea>

                    <div class="col-12 col-xs-12 col-lg-10 col-lg-offset-1 text-center">
                        <button class="button button-red mx-auto submit" type="submit">ZAPISZ</button>

                        @isset($product)
                            <x-form.input.hidden name="id" :value="$product->id" />
                        @endisset
                    </div>
                </div>
            </form>

            <div class="row">
                @isset($product)
                    <div class="col-xs-12">
                        <h1 class="page-header">Linki dla tego produktu:</h1>
                        @include('panel.link.section.table', ['route' => route('api.product.link', ['product' => $product->id])])
                    </div>
                @endisset
            </div>
        </div>
    </div>

@endsection
