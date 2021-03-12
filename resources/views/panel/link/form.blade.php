@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Link</h1>
                </div>
            </div>
            <form class="form row save" id="saveForm" method="{{ isset($link) ? 'put' : 'post' }}"
                  action="{{ route(isset($link) ? 'api.link.update' : 'api.link.add') }}">
                @csrf
                <div class="row">
                    <x-form.input.text name="url" placeholder="URL" required max="512" class-wrapper="col-xs-12 col-sm-6 col-sm-offset-3" :value="isset($link) ? $link->url : ''"/>

                    <x-form.select name="product_id" placeholder="Produkt" required :items="$products" class-wrapper="col-xs-12 col-sm-6 col-sm-offset-3" :selected="isset($link) ? $link->product_id : null" />

                    <div class="col-12 col-xs-12 col-lg-10 col-lg-offset-1 text-center">
                        <button class="button button-red mx-auto submit" type="submit">ZAPISZ</button>

                        @isset($link)
                            <x-form.input.hidden name="id" :value="$link->id" />
                        @endisset
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
