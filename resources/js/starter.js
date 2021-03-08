import $ from 'jquery';
import moment from 'moment';

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
            starter.main.onInputs();
            starter.main.onSubmit();
            starter.main.onShowBsModal();

            starter.datepicker.init();

            starter.form.styled();
        },

        onClick: function () {
            $(document).on("click", "button.button-uploads", function () {
                $(this).closest('.field').find("input[type=file]").trigger("click");
            });

            $(document).on('click', '#form .submit', function () {
                $('#form form#save').submit();
                return false;
            });
        },

        onChange: function () {
            $(document).on("change", ".select", function () {
                $(this).find('option[value=""]:checked').parent().addClass("empty");
                $(this)
                    .find('option:not([value=""]):checked')
                    .parent()
                    .removeClass("empty");
            });

            $(document).on('change', '.input, .textarea, .checkbox, .file', function (event) {
                const item = $(this);
                const name = $(this).attr('name');
                const valid = starter.form.validate(item, event);

                if (valid !== true) {
                    $(`.error-${name}`).text(valid).closest('.field').addClass('has-error');
                    starter._var.error[name] = valid;
                } else {
                    $(`.error-${name}`).text('').closest('.field').removeClass('has-error');
                    delete starter._var.error[name];

                    if (item.hasClass('upload-file')) {
                        const fileUpload = item[0].files[0];
                        const fieldId = item.attr('id');
                        const errorDiv = $(`.error-${fieldId}`);

                        errorDiv.text('');

                        if (fileUpload) {
                            let reader = new FileReader();

                            reader.onload = function (event) {
                                if (item.hasClass('upload-image')) {
                                    $(`#${fieldId}_thumb`).attr('src', event.target.result).parent().removeClass('hidden').next().addClass('hidden');
                                }
                            }
                            reader.readAsDataURL(fileUpload);
                        }
                    }
                }
            });

            $(document).on('dp.change', '#buyday', function (event) {
                const item = $(this);
                const name = $(this).attr('name');
                const valid = starter.form.validate(item, event);

                if (valid !== true) {
                    $(`.error-${name}`).text(valid).closest('.field').addClass('has-error');
                    starter._var.error[name] = valid;
                } else {
                    $(`.error-${name}`).text('').closest('.field').removeClass('has-error');
                    delete starter._var.error[name];
                }
            });
        },

        onInputs: function () {
            $(document).on("input", ".input", function (e) {
                e.target.value !== "" ? $(this).addClass("valid").removeClass("invalid") : $(this).removeClass("valid");
            });

            $(document).on("input", ".textarea", function (e) {
                e.target.value !== "" ? $(this).addClass("valid").removeClass("invalid") : $(this).removeClass("valid");
            });
        },

        onSubmit: function () {
            $(document).on('submit', '#form form', function () {
                $('.input, .textarea, .checkbox, .file').trigger('change');
                $('#buyday').trigger('dp.change');

                if (Object.keys(starter._var.error).length === 0) {
                    const fields = starter.form.getFields($(this).closest('form'));
                    const url = $(this).closest('form').attr('action');
                    const formData = new FormData();

                    for (const field in fields) {
                        formData.append(field, fields[field]);
                    }

                    axios({
                        method: 'post', url: url, headers: {
                            'content-type': 'multipart/form-data',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }, data: formData,
                    }).then(function (response) {
                        window.location = response.data.results.url;
                    }).catch(function (error) {
                        $(`.error-post`).text('');
                        if (error.response) {
                            Object.keys(error.response.data.errors).map((item) => {
                                $(`.error-${item}`).text(error.response.data.errors[item][0]);
                            });
                        } else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
                } else {
                    $('.error-post').text('');
                    for (let key in starter._var.error) {
                        if (starter._var.error.hasOwnProperty(key)) {
                            let value = starter._var.error[key];
                            $('.error-' + key).text(value);
                        }
                    }
                }

                return false;
            });
        },

        onShowBsModal: function () {
            $(document).on("show.bs.modal", "#modal", function (e) {
                const recipient = $(e.relatedTarget).data("product");

                $.getJSON(`/api/product/link/${recipient}`, function (jsonData) {
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

            switch (name) {
                case 'firstname':
                    return starter.form.validator.isName(value, 'Imię');
                case 'lastname':
                    return starter.form.validator.isName(value, 'Nazwisko');
                case 'address':
                    return starter.form.validator.isContent(value, 'Adres');
                case 'city':
                    return starter.form.validator.isName(value, 'Miejscowość');
                case 'zip':
                    return starter.form.validator.isZip(value, 'Miejscowość');
                case 'voivodeship':
                    return starter.form.validator.isOption(value, 'Województwo', 0, 15);
                case 'phone':
                    return starter.form.validator.isPhone(value, 'Telefon');
                case 'email':
                    return starter.form.validator.isEmail(value, 'Adres e-mail');
                case 'product':
                    return starter.form.validator.isOption(value, 'Produkt', 1);
                case 'shop_type':
                    return starter.form.validator.isOption(value, 'Rodzaj sklepu', 0, 1);
                case 'buyday':
                    console.log('buyday');
                    return starter.form.validator.isDate(value, 'Data zakupu', event);
                case 'shop':
                    return starter.form.validator.isOption(value, 'Sklep', 1);
                case 'number_receipt':
                    return starter.form.validator.isContent(value, 'Numer dowodu zakupu');
                case 'whence':
                    return starter.form.validator.isOption(value, 'Skąd wiesz', 1);
                case 'img_receipt':
                    return starter.form.validator.isFile(item, 'Zdjęcie paragonu');
                case 'img_ean':
                    return starter.form.validator.isFile(item, 'Zdjęcie kodu EAN');
                case 'legal_1':
                case 'legal_2':
                case 'legal_3':
                    return starter.form.validator.isLegal(item);
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
            isZip: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (!/^[0-9]{2}-[0-9]{3}$/.test(value)) {
                    return 'Wprowadź poprawny kod pocztowy.';
                } else {
                    return true;
                }
            },
            isOption: (value, name, min = false, max = false) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (isNaN(value)) {
                    return 'Wybierz opcje.';
                } else if (min !== false && parseInt(value) < min) {
                    return 'Wybierz opcje.';
                } else if (max !== false && parseInt(value) > max) {
                    return 'Wybierz opcje.';
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
            isProduct: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (isNaN(value) || parseInt(value) < 1) {
                    return 'Wybierz opcje.';
                } else {
                    return true;
                }
            },
            isDate: (value, name, event) => {
                console.log('isDate')
                console.log(event);
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
            isContent: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length > 128) {
                    return `Pole ${name} może mieć maksymalnie 128 znaków.`;
                } else {
                    return true;
                }
            },
        },

        styled: function () {
            $(".select").find('option[value=""]:checked').parent().addClass("empty");
        }
    },

    datepicker: {
        init: function () {
            const buyday = $('input#buyday');
            if (buyday.length) {
                buyday.datetimepicker({
                    format: 'DD-MM-YYYY',
                    // inline: true,
                    locale: 'pl',
                    // maxDate: moment().subtract(18, 'years')
                });
                $('input#firstname').focus();
            }
        }
    },
}

