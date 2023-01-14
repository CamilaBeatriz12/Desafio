$(document).ready(function () {
    //Ativa o tooltip para editar e deletar
    $('[data-toggle="tooltip"]').tooltip();

    //Marcar e desmarcar os checkboxes
    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function () {
        if (this.checked) {
            checkbox.each(function () {
                this.checked = true;
            });
        }
        else {
            checkbox.each(function () {
                this.checked = false;
            });
        }
    });
    checkbox.click(function () {
        if (!this.checked) {
            $("#selectAll").prop("checked", false);
        }
    });
});