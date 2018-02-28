/**Inicializador de fecha */
$('.datepicker').pickadate({
    selectMonths: true,
    selectYears: 15,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    format: 'yyyy/mm/dd',
    closeOnSelect: true
});
/**Inicializador de hora */
$('.timepicker').pickatime({
    default: 'now',
    fromnow: 0,
    twelvehour: false,
    donetext: 'OK',
    cleartext: 'Clear',
    canceltext: 'Cancel',
    autoclose: false,
    ampmclickable: true,
    aftershow: function () { } //Function for after opening timepicker
});

/** Petición Ajax **/
let respuestaAjax = "algo ha ido mal";
function peticionAjax(ajax) {
    $.ajax({
        url: ajax.url,
        type: ajax.tipo,
        dataType: 'json',
        data: ajax.datos,
        async: false,
        success: function (respuesta) {
            respuestaAjax = respuesta;
        }
    }).fail(function (error) {
        respuestaAjax = error;
    });
    return respuestaAjax;
}
/** Cargar Profes en select */
function cargarProfes() {
    let profesores = peticionAjax({ url: "./librerias/php/funciones.php", tipo: "post", datos: { rellenar: "ja" } });
    var objDatosProfes = {};
    console.log(profesores)
    $.each(profesores, function (id, value) {
        objDatosProfes[value.nombre] = null;
    });

    $('input.autocomplete').autocomplete({
        data: objDatosProfes,
        onAutocomplete: function (val) {
            let yaSeleccionado = false;
            $("#seleccion").children().each(function (i, d) {
                if (d.textContent === val) {
                    yaSeleccionado = true;
                }
            });
            (!yaSeleccionado) ? $("#seleccion").append("<div>" + val + "</div>") : toast("El profesor ya ha sido seleccionado, por favor seleccione otro!");
        }
    });
}

function toast(msg) {
    let x = document.getElementById("toast");
    x.innerHTML = msg;
    x.className = "show";
    setTimeout(function () { x.className = x.className.replace("show", ""); }, 3000);
}