$(function () {
    const table = $("#userTable").DataTable({
        pageLength: 25,
        order: [[0, "asc"]],
        dom:
            '<"row"<"col-md-6"l><"col-md-6"f>>' +
            '<"row"<"col-12"tr>>' +
            '<"row"<"col-md-5"i><"col-md-7"p>>',
    });

    $(".adminlte-search-input").on("keyup", function () {
        table.search(this.value).draw();
    });

    $(".delete-form-admin").on("submit", function (e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: "Delete user?",
            text: "This action cannot be undone",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dd4b39",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
