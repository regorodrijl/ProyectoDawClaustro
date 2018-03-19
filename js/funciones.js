var labelMonthNext = 'Mes siguiente';
var labelMonthPrev = 'Mes anterior';
var monthsFull = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
var monthsShort = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
var weekdaysFull = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
var weekdaysShort = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
var weekdaysLetter = ['D', 'L', 'M', 'X', 'J', 'V', 'S'];


/**Inicializador de fecha */
$('.datepicker').pickadate({
    selectMonths: true,
    selectYears: 15,
    labelMonthNext: labelMonthNext,
    labelMonthPrev: labelMonthPrev,
    monthsFull: monthsFull,
    monthsShort: monthsShort,
    weekdaysFull: weekdaysFull,
    weekdaysShort: weekdaysShort,
    weekdaysLetter: weekdaysLetter,
    min: new Date(),
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Aceptar',
    format: 'yyyy/mm/dd',
    closeOnSelect: true,
    onStart: function () {
        var date = new Date()
        this.set('select', [date.getFullYear(), date.getMonth(), date.getDate()]);
    },
});
/**Inicializador de hora */
$('.timepicker').pickatime({
    default: 'now',
    fromnow: 0,
    twelvehour: false,
    donetext: 'Aceptar',
    cleartext: 'Limpiar',
    canceltext: '',
    autoclose: false,
    ampmclickable: true,
    aftershow: function () { }
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

function toast(toast) {
    switch (toast.tipo) {
        case 'success':
            tipo = { i: 'check', color: '#28a745' }
            break;
        case 'error':
            tipo = { i: 'close', color: 'red' }
            break;
        case 'warning':
            tipo = { i: 'error_outline', color: '#ffc107' }
            break;
        case 'info':
            tipo = { i: 'info_outline', color: '#17a2b8' }
            break;
        default:
            tipo = { i: 'check', color: '#28a745' }
            break;
    }
    let x = document.getElementById("toast");
    x.innerHTML = toast.msg;
    x.className = "show";
    x.style.background = tipo.color;
    $('#toast').css('left', "calc(50% -  " + $('#toast').outerWidth() / 2 + "px)");
    $(x).prepend("<i class='material-icons'>" + tipo.i + "</i>");
    setTimeout(function () { x.className = x.className.replace("show", ""); }, 3000);
}
function seccionaHTML(data, param) {
    return $("div." + param, data)[0] || '';
}
function obtenerHTML(url) {
    let me = this,
        direcc = url,
        result = "";
    $.ajax({
        url: url,
        method: 'GET',
        async: false,
        success: function (data, status) {
            result = (!direcc.split('?')[1]) ? data : me.seccionaHTML(data, direcc.split('?')[1]);
        }
    });

    return typeof result == 'string' ? result : result.outerHTML;
}
function reemplazaMostachos(obj) {
    var cad = obj.html;
    for (var chd in obj) cad = cad.replace(new RegExp('{{' + chd + '}}', 'g'), (obj[chd] || ''));
    return cad;
}

function comprobarClaustrosYCambioEstado() {
    /**
     * Comproar si hay claustro activo y cambiarlos de esteado  
     * desactivar claustro activos.
    */
    let respuesta = peticionAjax({ url: "./librerias/php/funciones.php", tipo: "post", datos: { desactivar: "desactivar" } });
    if (respuesta == "ok") {
        toast({ msg: "No hay claustro activo para el día de hoy" });
    } else {
        toast({ msg: "Hay claustro activo para el día de hoy." });
    }
}
/**
 * Comprobar token
 */
var tokenUsuario;
function comprobarToken() {
    console.log('tks',tokenUsuario);
    if (tokenUsuario !== "" || tokenUsuario !== undefined) {
        //si no tiene token
        let respuesta = peticionAjax({ url: "./librerias/php/pass.php", tipo: "post", datos: { token: tokenUsuario } });
        if (respuesta == "ok") {
            return respuesta;
        } else {
            return respuesta;
        }
    }else{
        //tient token
    }
}
