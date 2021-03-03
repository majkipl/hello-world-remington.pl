import $ from 'jquery';

(function ($) {
    $.fn.matchMaxHeight = function () {
        const items = $(this);
        $(items).attr('style', '');
        $(items).css({});
        let max = 0;
        for (let i = 0; i < items.length; i++) {
            max = max < $(items[i]).height() ? $(items[i]).height() : max;

        }
        $(items).css({'display': 'block', 'height': '' + max + 'px'});
    }
})(jQuery);

$(window).on("load", () => {
    starter.main.init();
});

$(window).on("resize", () => {
});

$(window).scroll(() => {
});

const starter = {
    _var: {
        error: [], sorted: [], question: 0, answers: [], ts_s: 0, ts_e: 0,
    },

    main: {
        init: function () {
            starter.main.onClick();
            starter.main.onChange();
            starter.main.onSubmit();
            starter.main.onShowBsModal();
        },

        onClick: function () {

        },

        onChange: function () {

        },

        onSubmit: function () {

        },

        onShowBsModal: function () {
            $(document).on("show.bs.modal", "#modal", function (e) {
                const recipient = $(e.relatedTarget).data("product");

                $.getJSON(`/api/product/link/${recipient}`, function(jsonData) {
                    let modalBody = $("<div>")
                        .addClass("row")
                        .attr("id", "modal-body");

                    $.each(jsonData.rows, function (index, value) {
                        let brand = value.split("/")[2]; // Extracting brand from the URL
                        let sanitizedBrand = brand.replace(/[^a-zA-Z]/g, ''); // Removing non-alphabetic characters from brand

                        let productLink = $("<a>")
                            .addClass("product-link")
                            .attr("href", value)
                            .attr("target", "_blank")
                            .attr("rel", "noopener noreferrer")
                            .attr("aria-label", sanitizedBrand)
                            .attr("data-brand", sanitizedBrand);

                        let colDiv = $("<div>")
                            .addClass("col-12 col-sm-6")
                            .append(productLink);

                        modalBody.append(colDiv);
                    });

                    $(".modal-body").html(modalBody);
                });
            });
        }
    },

    form: {
        getFields: function ($form) {
            const inputs = $form.find('.input');
            const textareas = $form.find('.textarea');
            const checkboxes = $form.find('.checkbox');
            const files = $form.find('.file');
            const fields = {};

            $.each(inputs, function (index, item) {
                fields[$(item).attr('name')] = $(item).val();
            });

            $.each(textareas, function (index, item) {
                fields[$(item).attr('name')] = $(item).val();
            });

            $.each(checkboxes, function (index, item) {
                if ($(item).prop('checked')) {
                    fields[$(item).attr('name')] = $(item).val();
                }
            });

            $.each(files, function (index, item) {
                if (item.files[0]) {
                    fields[$(item).attr('name')] = item.files[0];
                }
            })

            fields['_token'] = $form.find('input[name=_token]').val();

            return fields;
        },

        validate: function (item, event) {
            const value = item.val().trim();
            const name = item.attr('name');
            const isMainPrize = $('#main_prize').val() ? 1 : 0;
            const isWeekPrize = $('#week_prize').val() ? 1 : 0;

            switch (name) {
                case 'firstname':
                    return event.type === 'change' ? starter.form.validator.isName(value, 'Imię') : true;
                case 'lastname':
                    return event.type === 'change' ? starter.form.validator.isName(value, 'Nazwisko') : true;
                case 'email':
                    return event.type === 'change' ? starter.form.validator.isEmail(value, 'Adres e-mail') : true;
                case 'phone':
                    return event.type === 'change' ? starter.form.validator.isPhone(value, 'Telefon') : true;
                case 'shop':
                    return event.type === 'change' ? starter.form.validator.isShop(value, 'Sklep') : true;
                case 'product_code':
                    return event.type === 'change' ? starter.form.validator.isProductCode(value, 'Kod kreskowy') : true;
                case 'whence':
                    return event.type === 'change' ? starter.form.validator.isWhence(value, 'Skąd wiesz o promocji') : true;
                case 'legal_1':
                case 'legal_2':
                case 'legal_3':
                case 'legal_4':
                case 'legal_7':
                    return event.type === 'change' ? starter.form.validator.isLegal(item) : true;
                case 'img_receipt':
                    return event.type === 'change' ? starter.form.validator.isFile(item, 'Zdjęcie paragonu') : true;
                case 'competition_title':
                    return event.type === 'change' && isMainPrize ? starter.form.validator.isName(value, 'Tytuł') : true;
                case 'competition_audio':
                    return event.type === 'change' && isMainPrize ? starter.form.validator.isFileAudio(item, 'Nagranie') : true;
                case 'timer':
                    return event.type === 'change' && isWeekPrize ? starter.form.validator.isTime(value) : true;
                case 'response':
                    return event.type === 'change' && isWeekPrize ? starter.form.validator.isAnswers(value) : true;
                case 'correct':
                    return event.type === 'change' && isWeekPrize ? starter.form.validator.isCorrect(value) : true;
                case 'birthday':
                    return event.type === 'dp' && event.namespace === 'change' ? starter.form.validator.isBirthday(value, 'Data urodzenia') : true;
                case 'name':
                    return event.type === 'change' ? starter.form.validator.isName(value, 'Imię') : true;
                case 'subject':
                    return event.type === 'change' ? starter.form.validator.isName(value, 'Tytuł wiadomości') : true;
                case 'message':
                    return event.type === 'change' ? starter.form.validator.isMessage(value, 'Treść wiadomości') : true;
                default:
                    return true;
            }
        },

        validator: {
            isName: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length < 3 || value.length > 128) {
                    return `Pole ${name} musi mieć od 3 do 128 znaków.`;
                } else if (!/^[\p{L}\s-]+$/u.test(value)) {
                    return `Pole ${name} może zawierać tylko litery.`;
                } else {
                    return true;
                }
            },
            isTime: (value) => {
                if (value === "") {
                    return `Musisz rozwiązać QUIZ i zgłosić wynik do konkursu.`;
                } else if (!/^\d+$/u.test(value)) {
                    return `Coś poszło nie tak. Spróbuj ponownie.`;
                } else {
                    return true;
                }
            },
            isAnswers: (value) => {
                if (value === "") {
                    return `Musisz rozwiązać QUIZ i zgłosić wynik do konkursu.`;
                } else {
                    return true;
                }
            },
            isCorrect: (value) => {
                if (value === "") {
                    return `Musisz rozwiązać QUIZ i zgłosić wynik do konkursu.`;
                } else if (value.length < 1 || value.length > 2) {
                    return `Coś poszło nie tak. Spróbuj ponownie.`;
                } else if (!/^\d+$/u.test(value)) {
                    return `Coś poszło nie tak. Spróbuj ponownie.`;
                } else {
                    return true;
                }
            },
            isShop: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length < 3 || value.length > 128) {
                    return `Pole ${name} musi mieć od 3 do 128 znaków.`;
                } else {
                    return true;
                }
            },
            isProductCode: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (!(value.length === 8 || value.length === 13 || value.length === 14)) {
                    return `Pole ${name} ma błędny format.`;
                } else if (!/^\d+$/u.test(value)) {
                    return `Pole ${name} może zawierać tylko cyfry.`;
                } else {
                    return true;
                }
            },
            isWhence: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (isNaN(value) || parseInt(value) < 1) {
                    return 'Wybierz opcje.';
                } else {
                    return true;
                }
            },
            isEmail: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length > 255) {
                    return `Pole ${name} może mieć maksymalnie 255 znaków.`;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                    return 'Wprowadź poprawny adres email.';
                } else {
                    return true;
                }
            },
            isPhone: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (!/^\+48(\s)?([1-9]\d{8}|[1-9]\d{2}\s\d{3}\s\d{3}|[1-9]\d{1}\s\d{3}\s\d{2}\s\d{2}|[1-9]\d{1}\s\d{2}\s\d{3}\s\d{2}|[1-9]\d{1}\s\d{2}\s\d{2}\s\d{3}|[1-9]\d{1}\s\d{4}\s\d{2}|[1-9]\d{2}\s\d{2}\s\d{2}\s\d{2}|[1-9]\d{2}\s\d{3}\s\d{2}|[1-9]\d{2}\s\d{4})$/.test(value)) {
                    return 'Wprowadź poprawny numer telefonu.';
                } else {
                    return true;
                }
            },
            isBirthday: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else {
                    return true;
                }
            },
            isLegal: (item) => {
                if (item.val() === "") {
                    return `Pole jest wymagane.`;
                } else if (!item.prop('checked')) {
                    return `Pole jest wymagane.`;
                } else {
                    return true;
                }
            },
            isMessage: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length < 3 || value.length > 4096) {
                    return `Pole ${name} musi mieć od 3 do 4096 znaków.`;
                } else {
                    return true;
                }
            },
            isFile: (file, name) => {
                const extension = file[0]?.files[0]?.name.split('.').pop().toLowerCase();
                if (file[0].files.length === 0) {
                    return `Pole ${name} jest wymagane.`;
                } else if (file[0].files[0].size > 4 * 1024 * 1024) {
                    return `Rozmiar pliku nie może przekraczać 4 MB`;
                } else if (['jpg', 'jpeg', 'png'].indexOf(extension) === -1) {
                    return `Można wybrać tylko pliki graficzne JPG, JPEG lub PNG`;
                } else {
                    return true;
                }
            },
            isFileAudio: (file, name) => {
                const extension = file[0]?.files[0]?.name.split('.').pop().toLowerCase();
                if (file[0].files.length === 0) {
                    return `Pole ${name} jest wymagane.`;
                } else if (file[0].files[0].size > 2 * 1024 * 1024) {
                    return `Rozmiar pliku nie może przekraczać 2 MB`;
                } else if (['mp3'].indexOf(extension) === -1) {
                    return `Można wybrać tylko pliki audio MP3`;
                } else {
                    return true;
                }
            },
        },
    },

}

