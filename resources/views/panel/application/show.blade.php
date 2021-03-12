@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Zgłoszenie</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Zgłoszenie {{ $application->id }}</div>
                        <div class="panel-body">
                            <table class="item show data">
                                <tbody>
                                <tr>
                                    <td>Imię: </td>
                                    <td>{{ $application->firstname }}</td>
                                </tr>
                                <tr>
                                    <td>Nazwisko: </td>
                                    <td>{{ $application->lastname }}</td>
                                </tr>
                                <tr>
                                    <td>Adres: </td>
                                    <td>{{ $application->address }}</td>
                                </tr>
                                <tr>
                                    <td>Miasto: </td>
                                    <td>{{ $application->city }}</td>
                                </tr>
                                <tr>
                                    <td>Kod pocztowy: </td>
                                    <td>{{ $application->zip }}</td>
                                </tr>
                                <tr>
                                    <td>Województwo: </td>
                                    <td>{{ $application->voivodeship }}</td>
                                </tr>
                                <tr>
                                    <td>Adres e-mail: </td>
                                    <td>{{ $application->email }}</td>
                                </tr>
                                <tr>
                                    <td>Telefon: </td>
                                    <td>{{ $application->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Rodzaj sklepu: </td>
                                    <td>{{ $application->shop_type }}</td>
                                </tr>
                                <tr>
                                    <td>Produkt: </td>
                                    <td>{{ $application->shop->name }}</td>
                                </tr>
                                <tr>
                                    <td>Numer dowodu zakupu: </td>
                                    <td>{{ $application->number_receipt }}</td>
                                </tr>
                                <tr>
                                    <td>Zdjęcie dowodu zakupu: </td>
                                    <td><img src="{{ asset('storage/' . $application->img_receipt) }}" alt="Dowód zakupu dla zgłoszenia: {{ $application->id }}" /></td>
                                </tr>
                                <tr>
                                    <td>Zdjęcie kodu EAN: </td>
                                    <td><img src="{{ asset('storage/' . $application->img_receipt) }}" alt="Dowód zakupu dla zgłoszenia: {{ $application->id }}" /></td>
                                </tr>
                                <tr>
                                    <td>Produkt: </td>
                                    <td>{{ $application->product->name }}</td>
                                </tr>
                                <tr>
                                    <td>Skąd wiesz o promocji: </td>
                                    <td>{{ $application->whence->name }}</td>
                                </tr>
                                <tr>
                                    <td>Legal 1: </td>
                                    <td>{{ $application->legal_1 ? 'TAK' : 'NIE' }}</td>
                                </tr>
                                <tr>
                                    <td>Legal 2: </td>
                                    <td>{{ $application->legal_2 ? 'TAK' : 'NIE' }}</td>
                                </tr>
                                <tr>
                                    <td>Legal 3: </td>
                                    <td>{{ $application->legal_3 ? 'TAK' : 'NIE' }}</td>
                                </tr>
                                <tr>
                                    <td>Legal 4: </td>
                                    <td>{{ $application->legal_4 ? 'TAK' : 'NIE' }}</td>
                                </tr>
                                <tr>
                                    <td>Legal 5: </td>
                                    <td>{{ $application->legal_5 ? 'TAK' : 'NIE' }}</td>
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
