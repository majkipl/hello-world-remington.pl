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
</script>
