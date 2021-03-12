@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sklep</h1>
                </div>
            </div>
            <form class="form row save" id="saveForm" method="{{ isset($shop) ? 'put' : 'post' }}"
                  action="{{ route(isset($shop) ? 'api.shop.update' : 'api.shop.add') }}">
                @csrf
                <div class="row">
                    <x-form.input.text name="name" placeholder="Nazwa" required max="255" class-wrapper="col-xs-12 col-sm-6 col-sm-offset-3" :value="isset($shop) ? $shop->name : ''"/>

                    <div class="col-12 col-xs-12 col-lg-10 col-lg-offset-1 text-center">
                        <button class="button button-red mx-auto submit" type="submit">ZAPISZ</button>

                        @isset($shop)
                            <x-form.input.hidden name="id" :value="$shop->id" />
                        @endisset
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
