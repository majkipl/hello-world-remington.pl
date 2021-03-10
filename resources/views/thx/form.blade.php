@extends('layouts.front')

@section('content')
    <section class="thankyou-top" id="top">
        <div class="content"></div>
        <div class="title-img"></div>
    </section>

    <section class="thankyou-info" id="dziekujemy">
        <div class="container">
            <p class="info">Potwierdzenie Twojego zgłoszenia do promocji Hello World zostało wysłane na wskazany w
                formularzu adres mailowy.<br/><br/>Numer Twojego zgłoszenia: <strong>{{ $id }}</strong><br/>Zgłoszenie
                zostanie zweryfikowane pod względem zgodności z Regulaminem.</p>
        </div>
    </section>
@endsection
