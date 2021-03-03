<footer class="footer">
    <div class="container">
        <div class="row social-row">
            <div class="col-auto">
                <a href="/" aria-label="Remington">
                    <img class="logo" src="{{ asset('images/svg/logo-white.svg') }}" alt="Logo" />
                </a>
            </div>
            <div class="col-auto socials">
                <a class="social" href="https://www.instagram.com/remingtonstyle/?hl=pl" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    {!! file_get_contents(public_path('images/svg/icon/instagram.svg')) !!}
                    <span class="social-name">Instagram</span>
                </a>
                <a class="social" href="https://www.youtube.com/user/remingtonpolska" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                    {!! file_get_contents(public_path('images/svg/icon/youtube.svg')) !!}
                    <span class="social-name">YouTube</span>
                </a>
                <a class="social" href="https://www.facebook.com/RemingtonPolska/" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    {!! file_get_contents(public_path('images/svg/icon/facebook.svg')) !!}
                    <span class="social-name">Facebook</span>
                </a>
            </div>
        </div>
        <p class="info"><a class="link" href="https://pl.remington-europe.com/polityka-prywatno%C5%9Bci" target="_blank" rel="noopener noreferrer">Polityka prywatności</a></p>
    </div>
</footer>
