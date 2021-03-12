<script>
    function btAjax(params) {
        const headers = {
            'Authorization': 'Bearer ' + token
        };

        const urlWithParams = params.url + '?' + $.param(params.data);

        $.ajax({
            url: urlWithParams,
            type: 'GET',
            dataType: 'json',
            headers: headers,
            success: function(response) {
                params.success(response);
            },
            error: function(error) {
                params.error(error);
            }
        });
    }

    window.customSearchFormatter = function (value, searchText) {
        return value.toString().replace(new RegExp('(' + searchText + ')', 'gim'), '<span style="background-color: pink;border: 1px solid red;border-radius:90px;padding:4px">$1</span>')
    }

    window.dateFormatter = function (value, row) {
        return moment(value).format("YYYY-MM-DD HH:mm:ss");
    }

    window.legalFormatter = function (value, row) {
        return value ? 'TAK' : 'NIE';
    }

    window.actionsEvents = {}

    function getBtButtons(route) {
        return {
            btnAdd: {
                text: "Dodaj nowy",
                icon: "bi-plus-square",
                event: function () {
                    window.location.href = route;
                },
                attributes: {
                    title: "Dodaj nowy",
                },
                render: true,
            },
        };
    }
</script>
