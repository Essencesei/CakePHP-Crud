$(document).ready(function () {
    $("#dataTable").DataTable({
        ajax: {
            url: "/product/getdata",
            dataSrc: "data",
        },
        processing: true,
        serverSide: true,
        columns: [
            { data: "product_id" },
            { data: "name" },
            {
                data: "price",
                render: function (data, type, row) {
                    return new Intl.NumberFormat("en-ph", {
                        style: "currency",
                        currency: "PHP",
                    }).format(data);
                },
            },
            { data: "stock_quantity" },
            { data: "category" },
            {
                data: "",
                render: function (data, type, row) {
                    return `<a class="btn btn-primary"  href="${editUrl}/${row.product_id}">Edit</a> 
                    <a class="btn btn-secondary"  href="${viewUrl}/${row.product_id}">View</a>
                    `;
                },
                sortable: false,
            },
        ],
    });
});
