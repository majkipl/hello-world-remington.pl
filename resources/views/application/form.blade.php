@extends('layouts.front')

@section('content')
    <section class="form-top" id="top">
        <div class="content"></div>
        <div class="title-img"></div>
    </section>

    <section class="form" id="form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form class="form" method="post" id="save" action="{{ route('front.application.save') }}">
                        @csrf
                        <div class="row row-form">
                            <x-form.input.text name="firstname" placeholder="Imię" required max="128" class-wrapper="col-12 col-md-6" />
                            <x-form.input.text name="lastname" placeholder="Nazwisko" required max="128" class-wrapper="col-12 col-md-6" />
                            <x-form.input.text name="address" placeholder="Adres" required max="128" class-wrapper="col-12 col-md-6" />
                            <x-form.input.text name="city" placeholder="Miejscowość" required max="128" class-wrapper="col-12 col-md-6" />
                            <x-form.input.text name="zip" placeholder="Kod pocztowy" required max="6" class-wrapper="col-12 col-md-6" />
                            <x-form.select name="voivodeship" placeholder="Województwo" required :items="$voivodeships" class-wrapper="col-12 col-md-6" />
                            <x-form.input.text name="phone" placeholder="Telefon" required max="32" class-wrapper="col-12 col-md-6" />
                            <x-form.input.email name="email" placeholder="Adres e-mail" required max="320" class-wrapper="col-12 col-md-6" />
                        </div>

                        <div class="row row-form">
                            <x-form.select name="product" placeholder="Zakupiony produkt" required :items="$products" class-wrapper="col-12 col-md-6" />
                            <x-form.select name="shop_type" placeholder="Rodzaj sklepu" required :items="$shopTypes" class-wrapper="col-12 col-md-6" />
                            <x-form.input.text name="buyday" placeholder="Data zakupu [DD-MM-YYYY]" required max="10" class-wrapper="col-12 col-md-6" />
                            <x-form.select name="shop" placeholder="W jakim sklepie został zakupiony produkt" required :items="$shops" class-wrapper="col-12 col-md-6" />
                            <x-form.input.text name="number_receipt" placeholder="Nr dowodu zakupu" required max="128" class-wrapper="col-12 col-md-6" />
                            <x-form.select name="whence" placeholder="Skąd wiesz o promocji?" required :items="$whences" class-wrapper="col-12 col-md-6" />
                        </div>

                        <x-form.input.file name="img_receipt" required>
                            <img class="file-img" src="{{ asset('/images/svg/form/file.svg') }}" alt="Zdjęcie dowodu zakupu" />
                            <p class="file-text">Dodaj zdjęcie dowodu zakupu</p>
                        </x-form.input.file>
                        <x-form.input.file name="img_ean" required>
                            <img class="file-img" src="{{ asset('/images/form/ean.png') }}" alt="Zdjęcie kodu EAN" />
                        </x-form.input.file>

                        <div class="row row-form">
                            <x-form.input.checkbox name="legal_1" required class-wrapper="col-12">
                                Zapoznałe(a)m się z regulaminem akcji Hello World i wyrażam zgodę na wszystkie jego postanowienia.
                            </x-form.input.checkbox>

                            <x-form.input.checkbox name="legal_2" required class-wrapper="col-12">
                                Zapoznałe(a)m się z Polityką prywatności.
                            </x-form.input.checkbox>

                            <x-form.input.checkbox name="legal_3" required class-wrapper="col-12">
                                Wyrażam zgodę na przetwarzanie przez Spectrum Brands Poland sp. z o.o. z siedzibą w Warszawie, jako administratora, moich danych osobowych podanych przeze mnie w formularzu powyżej, w celu przekazywania mi newslettera zawierającego informacje marketingowe dotyczące produktów Spectrum Brands (oferowanych pod markami Remington, Russell Hobbs oraz George Foreman). Oświadczam, że zostałam/em poinformowana/y, że zgoda jest dobrowolna oraz, że mogę ją wycofać w każdym czasie.
                            </x-form.input.checkbox>

                            <x-form.input.checkbox name="legal_4" class-wrapper="col-12">
                                Wyrażam zgodę na przesyłanie informacji handlowych dotyczących produktów Spectrum Brands (oferowanych pod markami Remington, Russell Hobbs oraz George Foreman) za pomocą środków komunikacji elektronicznej (w tym celu udostępniam swój adres e-mail) przez Spectrum Brands Poland sp. z o.o. z siedzibą w Warszawie. Oświadczam, że zostałam/em poinformowana/y, że zgoda jest dobrowolna oraz, że mogę ją wycofać w każdym czasie.
                            </x-form.input.checkbox>

                            <x-form.input.checkbox name="legal_5" class-wrapper="col-12">
                                Wyrażam zgodę na używanie telekomunikacyjnych urządzeń końcowych i automatycznych systemów wywołujących dla celów marketingu bezpośredniego dotyczącego produktów Spectrum Brands (oferowanych pod markami Remington, Russell Hobbs oraz George Foreman) przez Spectrum Brands Poland sp. z o.o. z siedzibą w Warszawie, za pomocą środków komunikacji elektronicznej (e-mail). Oświadczam, że zostałam/em poinformowana/y, że zgoda jest dobrowolna oraz, że mogę ją wycofać w każdym czasie.
                            </x-form.input.checkbox>
                        </div>

                        <div class="row row-form">
                            <div class="col-12">
                                <div class="button-box">
                                    <button type="submit" class="button submit">Wyślij formularz</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
