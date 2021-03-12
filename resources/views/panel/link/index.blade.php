@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                @include('panel.link.section.table', ['route' => route('api.link')])
            </div>
        </div>
    </div>
@endsection
