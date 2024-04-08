function init() {
    HandlePaginate();
    HandlePerPage();
}

function HandlePaginate() {
    $('.paginate-button').click(function (event) {
        event.preventDefault();
        const page = $(this).attr('data-page')
        execLoadPage(page);
    })
}

function HandlePerPage() {
    $('#select-per-page').change(function () {
        $('#perPage').val($(this).val())
        execLoadPage();
    })
}

function execLoadPage(page = 1) {
    const per_page = $('#perPage').val();
    const data = {};
    $('#table_order_customer tbody').empty();
    $("#frm-searching-customer").serializeArray().map(function (x) {
        data[x.name] = x.value;
    });

    data['number_of_page'] = per_page;
    data['page'] = page;
    $.request('onSubmitSearchCustomer', {
        data: data
    }).done(function () {
        $('#current_page').val(page);
        UpdateCustomer();
    });
}

init();
