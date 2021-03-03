<section class="home-products" id="produkty">
    <div class="content">
        <div class="container">
            <h2 class="title">Produkty</h2>
        </div>
        <div class="container">
            <h3 class="subtitle">Prostownice</h3>
        </div>
        <div class="container">
            <div class="row products">
                @foreach($products as $product)
                    <div class="col-md-6 col-xl-4">
                        <a class="product" href="#" data-toggle="modal" data-target="#modal" data-product="{{ $product->id }}">
                            <h5 class="minititle">{{ $product->code }}</h5>
                            <img class="product-img" src="{{ asset('images/home/products/' . \Illuminate\Support\Str::lower($product->code) . '.png') }}"
                                 alt="{{ $product->name }}"/>
                            <h4 class="product-name">{{ $product->name }}</h4>
                            <p class="product-text">{{ $product->text }}</p>
                            <div class="button product-button">Sprawdź cenę</div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
