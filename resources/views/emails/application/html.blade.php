<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        u + .body {
            line-height: 100% !important;
        }
    </style>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; margin: 0;">

<div style="background-color: #fff; width: 700px; padding: 5px 0; margin: 0 auto;">
    <a style="display: inline-block; margin-left: 15px;" href="#" target="_blank" rel="noopener noreferrer" aria-label="Remington">
        <img style="width: 157px; height: 46px;" src="{{ asset('images/svg/mail/logo-black.svg') }}" alt="Logo">
    </a>
</div>

<div style="background-color: #fff; width: 700px; margin: 0 auto; overflow: hidden;">
    <img style="width: 868px; height: 294px; margin-left: -183px;" src="{{ asset('images/mail/top.jpg') }}" alt="">
</div>

<div style="background-color: #fff; width: 700px; margin: 0 auto; padding: 20px 0;">
    <p style="margin: 30px 85px; color: #000; font-size: 16px; font-weight: bold; line-height: 24px; text-align: center; letter-spacing: 1px;">Dziękujemy za udział w promocji Hello World marki Remington. Twoje zgłoszenie zostanie zweryfikowane pod względem zgodności z Regulaminem.</p>
    <p style="margin: 30px 85px; color: #e52713; font-size: 16px; font-weight: bold; line-height: 24px; text-align: center; letter-spacing: 1px;">Numer Twojego zgłoszenia: <strong>{{ $details['id'] }}</strong></p>
    <p style="margin: 30px 85px; color: #000; font-size: 16px; font-weight: bold; line-height: 24px; text-align: center; letter-spacing: 1px;">W razie braków w formularzu skontaktujemy się z Tobą mailowo w celu ich uzupełnienia.<br><br>Pamiętaj, że wiadomość od nas może trafić do SPAMU.</p>
</div>

<div style="overflow: hidden;">
    <div style="background-color: #000; width:  700px; margin: 0 auto; padding: 90px 0; transform: skewY(174deg); transform-origin: 100%;">
        <div style="margin: 0 45px; transform: skewY(-174deg);">
            <div style="float: left;">
                <a style="display: inline-block; margin: 6px 0;" href="#" target="_blank" rel="noopener noreferrer" aria-label="Remington">
                    <img style="width: 157px; height: 46px;" src="{{ asset('images/svg/mail/logo-white.svg') }}" alt="Logo">
                </a>
            </div>
            <div style="float: right;">
                <a style="display: inline-block; margin-left: 30px; text-decoration: none;" href="https://www.instagram.com/remingtonstyle/?hl=pl" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    <img style="display: block; margin: 0 auto 15px;" src="{{ asset('images/svg/mail/instagram.svg') }}" alt="Instagram">
                    <span style="display: block; color: #fff; font-weight: bold; font-size: 11px; line-height: 17px; text-transform: uppercase; letter-spacing: 1px;">Instagram</span>
                </a>
                <a style="display: inline-block; margin-left: 30px; text-decoration: none;" href="https://www.youtube.com/user/remingtonpolska" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <img style="display: block; margin: 0 auto 15px;" src="{{ asset('images/svg/mail/youtube.svg') }}" alt="YouTube">
                    <span style="display: block; color: #fff; font-weight: bold; font-size: 11px; line-height: 17px; text-transform: uppercase; letter-spacing: 1px;">YouTube</span>
                </a>
                <a style="display: inline-block; margin-left: 30px; text-decoration: none;" href="https://www.facebook.com/RemingtonPolska/" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                    <img style="display: block; margin: 0 auto 15px;" src="{{ asset('images/svg/mail/facebook.svg') }}" alt="Facebook">
                    <span style="display: block; color: #fff; font-weight: bold; font-size: 11px; line-height: 17px; text-transform: uppercase; letter-spacing: 1px;">Facebook</span>
                </a>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</div>

</body>
</html>
