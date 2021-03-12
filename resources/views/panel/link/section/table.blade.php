<table
    class="bt-table"
    data-buttons="buttons"
    data-buttons-align="right"
    data-filter-control="true"
    data-locale="pl-PL"
    data-pagination="true"
    data-remember-order="true"
    data-search="true"
    data-search-align="left"
    data-search-highlight="true"
    data-searchable="true"
    data-side-pagination="server"
    data-show-columns="true"
    data-show-columns-search="true"
    data-show-columns-toggle-all="true"
    data-show-export="true"
    data-show-pagination-switch="true"
    data-show-refresh="true"
    data-show-search-clear-button="true"
    data-show-toggle="true"
    data-show-fullscreen="true"
    data-sort-class="table-active"
    data-sortable="true"
    data-toggle="table"
    data-url="{{ $route }}"
    data-ajax="btAjax"
>
    <thead>
    <tr>
        <th
            data-field="id"
            data-sortable="true"
            data-search-highlight-formatter="customSearchFormatter"
            data-valign="middle"
            data-filter-control="input"
        >
            ID
        </th>
        <th
            data-field="url"
            data-sortable="true"
            data-search-highlight-formatter="customSearchFormatter"
            data-valign="middle"
            data-filter-control="input"
        >
            Url
        </th>
        <th
            data-field="product.code"
            data-sortable="true"
            data-search-highlight-formatter="customSearchFormatter"
            data-valign="middle"
            data-filter-control="input"
        >
            Kod producenta
        </th>
        <th
            data-field="product.name"
            data-sortable="true"
            data-search-highlight-formatter="customSearchFormatter"
            data-valign="middle"
            data-filter-control="input"
        >
            Produkt
        </th>
        <th
            data-field="actions"
            class="text-center"
            data-valign="middle"
            data-searchable="false"
            data-formatter="actionsFormatter"
        ></th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@include('panel.common.btajax')

<script>
    window.actionsFormatter = function (value, row, index) {
        const view_button = [
            '<a href="{{ route('back.link') }}/' + row.id + '" title="Zobacz" class="show icon">',
            '   <i class="bi bi-eye-fill"></i>',
            '</a>',
            '<a href="{{ route('back.link') }}/zmien/' + row.id + '" title="Zmień" class="edit icon">',
            '   <i class="bi bi-pencil-square"></i>',
            '</a>',
            '<a href="{{ route('api.link') }}" title="Usuń" class="remove icon" data-id="' + row.id + '">',
            '   <i class="bi bi-trash"></i>',
            '</a>'
        ].join('');
        return view_button ;
    }

    function buttons() {
        return getBtButtons('{{ route('back.link.create') }}');
    }
</script>
