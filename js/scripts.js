$(document).ready(function () {
    // Actualizar profes.
    //var datosProfesActualizar =  '< php echo json_encode($result); ?>';
    //datosProfesActualizar = "datos";//JSON.parse(datosProfesActualizar);
    // poner: cargando...
    //antes del parche
    /*   $.ajax({
         url: "./librerias/php/funciones.php",
         type: 'post',
         dataType: 'json',
         data: {datos:datosProfesActualizar},
         success:function(respuesta){
           $('div#contenidoAjax').hide();
           if(respuesta=="ok"){
             $select = $('#selecProfe');
             //rellenar select
             $.ajax({
               url: "./librerias/php/funciones.php",
               type: 'post',
               dataType: 'json',
               data: {rellenar:"ja"},
               success:function(respuesta){
                 $.each(respuesta, function(id,value){
                   $('<option/>').val(value.nombre).text(value.nombre).appendTo($("#selecProfe"));
                 });
                 $('.selectpicker').selectpicker('refresh');
               }      
             });
             alert("Profesores actualizados correctamente!!");
           }else alert("Error al actualizar!");
         }      
       }).fail( function(error) {
         console.log(error); 
       });// fin Botón Atualizar Profes
   */
    //IMPRIMIR
    $("#imprimir").click(function () {
        debugger
        $('div#contenidoAjax').show();
        var datosPDF = { "title": $("#tituloEdit").val(), "date": $("#diaEdit").val(), "curso": $("#cursoEdit").val(), "hi": $("#hiEdit").val(), "hf": $("#hfEdit").val(), "or": $("#orEdit").val(), "ob": $("#obEdit").val(), "firmas": profesPDF };

        console.log("DATOS A ENVIAR:", datosPDF);
        var name = $("#diaEdit").val();
        $.ajax({
            type: "POST",
            dataType: 'text',
            dataType: 'json',
            url: "./librerias/php/funciones.php",
            data: { pdf: datosPDF, nombre: name },
            success: function (pdf) {
                $('div#contenidoAjax').hide();
                console.log("url->", pdf);

                a = document.createElement("a");
                a.download = "Claustro" + name + ".pdf";
                a.href = pdf;
                a.click();

                window.open(pdf, '_blank');
            }
        });

    });//fin imprimir
});
/******************************************
 * ****************************************
 * *************** 2018 *********************
 * ****************************************
 */
//Nueva parte  por revisar parte anterior 2018

$(document).ready(function () {
    comprobarToken();

    var profesPDF = [];
    $('#loginRegistro').click(function () {
        $('.login').css('display') == 'none' ? $('.login').css('display', 'block') : $('.login').css('display', 'none');
        $('.registro').css('display') == 'none' ? $('.registro').fadeIn() : $('.registro').fadeOut();
        $('.registro').css('display') == 'block' ? $('.registro').css('display', 'flex') : $('.registro').css('display', 'none');

    });
    $('#login').click(function () {
        let registro = {
            "usuario": $("#user").val(),
            "password": $("#password").val()
        };
        let respuesta = peticionAjax({ url: "./librerias/php/pass.php", tipo: "post", datos: { login: registro } });
        console.log('resp->', respuesta);
        if (respuesta.status === 200 || respuesta.status === 'ok') {
            tokenUsuario = respuesta.result;
            debugger
            window.location.href = "/ProyectoDawClaustro/portal.html";
            toast({ msg: "Usuario registrado Correctamente!" });
        } else {
            debugger
            toast({ msg: respuesta.result, tipo: 'error' });
        }
    });
    $('#registrarse').click(function () {
        if ($("#usuarioRegistro").val() !== undefined && $("#emailRegistro").val() !== undefined && $("#passwordRegistro").val() !== undefined) {
            //peticion
            let registro = {
                "usuario": $("#usuarioRegistro").val(),
                "email": $("#emailRegistro").val(),
                "password": $("#passwordRegistro").val()
            };
            let respuesta = peticionAjax({ url: "./librerias/php/pass.php", tipo: "post", datos: { registrarse: registro } });
            if (respuesta.status === 'ok') {
                toast({ msg: "Usuario registrado Correctamente!" });
            }
            $('#cancelarRegistro').trigger("click");
        }
    });
    $('#cancelarRegistro').click(function () {
        $('.registro').css('display') == 'none' ? $('.registro').css('display', 'block') : $('.registro').css('display', 'none');
        $('.login').css('display') == 'none' ? $('.login').fadeIn() : $('.login').fadeOut();
        $('.login').css('display') == 'block' ? $('.login').css('display', 'flex') : $('.login').css('display', 'flex');
    });
    $('#botonNuevo').click(function () {
        $('#modalNuevo').modal();
        cargarProfes();
    });
    $('.modal-close').click(function () {
        $('.modal').hide();
    });
    $('.modal-overlayClautro').click(function () {
        $('.modal-overlayClautro').hide();
        $('.modalClautro').hide();
    });
    $("#reset").click(function () {
        location.reload();
    });

    comprobarClaustrosYCambioEstado();
    // CREAR NUEVO CLAUSTRO
    $("#crearClaustro").click(function () {
        //comprobar si hay clautro activo para esa fecha.     
        console.log("cambio fecha " + $("#fecha").val());
        if ($("#tituloClaustro").val() == "" && $("#fecha").val() == "" && $("#primeraConvocatoria").val() == "" && $("#segundaConvocatoria").val() == "" && $("#curso").val() == "" && $("#orden").val() == "") {
            toast({ msg: "Relleno los campos: Título, día, Fecha, Hora Inicio, Hora Fin, Curso, Orden del Día y seleccione profesores.", tipo: 'warning' })
        } else {
            if ($("#fecha").val() != undefined && $("#fecha").val() !== '') {
                let respuesta = peticionAjax({ url: "./librerias/php/funciones.php", tipo: "post", datos: { fecha: $("#fecha").val() } });
                if (respuesta == "ok") {
                    let profes = [];
                    $("#seleccion").children().each(function (i, d) {
                        profes.push(d.textContent);
                    });
                    console.log('cuantos profes: ' + profes.length);
                    if ($("#tituloClaustro").val() == "" || $("#fecha").val() == "" || $("#primeraConvocatoria").val() == "" || $("#segundaConvocatoria").val() == "" || $("#curso").val() == "" || $("#orden").val() == "") {
                        toast({ msg: "Relleno los campos: Título, día, Fecha, Hora Inicio, Hora Fin, Curso, Orden del Día y seleccione profesores.", tipo: 'warning' })
                    } else {
                        let claustro = {
                            "titulo": $("#tituloClaustro").val(),
                            "dia": $("#fecha").val(),
                            "primeraConvocatoria": $("#primeraConvocatoria").val(),
                            "segundaConvocatoria": $("#segundaConvocatoria").val(),
                            "curso": $("#curso").val(),
                            "orden": $("#orden").val(),
                            "observacion": $("#observacion").val(),
                            "profesores": profes
                        };
                        let creacionClaustro = peticionAjax({ url: "./librerias/php/funciones.php", tipo: "post", datos: { claustro: claustro } });
                        if (creacionClaustro == "ko") {
                            toast({ msg: "Ha habido algún error!" });
                        } else {
                            $("#tituloClaustro").val('');
                            $("#curso").val('');
                            $("#orden").val('');
                            $("#observacion").val('');
                            $("#fecha").val('');
                            $("#primeraConvocatoria").val('');
                            $("#segundaConvocatoria").val('');
                            toast({ msg: "Claustro creado correctamente! <br/> RECUERDE! sólo estará activo el mismo día!" });
                            $('.modal').hide();
                        }
                    }
                } else {
                    toast({ msg: "No se puede crear, revise el día" });
                    console.log("error-> " + respuesta);
                }
                $("#botonHistorico").trigger("click");
            } else {
                toast({ msg: "Rellene el campo fecha", tipo: 'warning' });
            }
        }
    });//fin botón CrearClaustro

    //HISTORICO
    var datos;
    $("#botonHistorico").click(function () {
        //abrimos la modal
        $('#modalHistorico').modal();
        //Vamos hace peticion ajax;
        let respuesta = peticionAjax({ url: "./librerias/php/funciones.php", tipo: "post", datos: { historicos: "Claustro historico" } });
        console.log("respuesta ajax", respuesta);
        //Procesamos datos
        let tabla = "<table id='tabla' border='1px'><tr class='cabezaTabla'><th>Título</th><th>Día</th><th>Cursos</th></tr>";
        for (let i in respuesta) {
            tabla += "<tr class='filaTabla' id=" + respuesta[i].id + "><td>" + respuesta[i].titulo + "</td><td>" + respuesta[i].dia + "</td><td>" + respuesta[i].curso + "</td></tr>";
        }
        tabla += "</table>";
        // imprimimos tabla
        $("#historicoClaustros").html(tabla);
        // hacemos clickeable
        $('tr').click(function () {
            $(this).parents('table').find('tr').each(function (index, element) {
                $(element).removeClass('color');
            });
            $(this).addClass('color');
        });

        $("#tabla tr td").click(function () {
            let meClick = $(this);
            let x = $(this).parent("tr");
            let respuestaTabla = peticionAjax({ url: "./librerias/php/funciones.php", tipo: "post", datos: { historico: x.attr('id') } });
            if (respuestaTabla.status == 'ok') {
                profesPDF = [];
                console.log("datos  ", respuestaTabla);
                let objeto = {};
                objeto.titulo = respuestaTabla.result[0].titulo;
                objeto.curso = respuestaTabla.result[0].curso;
                objeto.dia = respuestaTabla.result[0].dia;
                objeto.primeraConvocatoria = respuestaTabla.result[0].primeraConvocatoria;
                objeto.segundaConvocatoria = respuestaTabla.result[0].segundaConvocatoria;
                objeto.orden = respuestaTabla.result[0].orden;
                objeto.observacion = respuestaTabla.result[0].observacion;
                objeto.html = obtenerHTML('/ProyectoDawClaustro/porcionHtml.html?modalClaustro');
                let cadena = reemplazaMostachos(objeto);
                $('#modalClautro').html(cadena);
                $("#modalClautro").show();
                $(".modal-overlayClautro").show();
                $('.cerrarModalClaustro').click(function () {
                    $('.modal-overlayClautro').hide();
                    $('.modalClautro').hide();
                });

                $('.tablaFirmas').html("");
                if (respuestaTabla.result[1] != undefined) {
                    let objFirmas = {};
                    for (let i = 0; i < respuestaTabla.result[1].length; i++) {
                        objFirmas.html = obtenerHTML('/ProyectoDawClaustro/porcionHtml.html?filaTablaFirma');
                        console.log("FIRMA", respuestaTabla.result[1][i].firma.length);
                        if (respuestaTabla.result[1][i].firma.length <= 23) {
                            objFirmas.nombre = [respuestaTabla.result[2][i].nombre];
                        } else {
                            objFirmas.nombre = [respuestaTabla.result[2][i].nombre];
                            objFirmas.firma = [respuestaTabla.result[1][i].firma];
                        }
                        let cadenaFirmas = reemplazaMostachos(objFirmas);
                        $('.tablaFirmas').append(cadenaFirmas);
                    }
                }
                // para evitar problemas con id
                $("#borrar").off("click");

                $("#borrar").click(function () {
                    let idBorrar = meClick.parent()[0].id;
                    console.log(meClick.parent()[0].id, "dentro de borrar, id:", idBorrar);
                    let respuestaBorrar = peticionAjax({ url: "./librerias / php / funciones.php", tipo: "post", datos: { borrar: idBorrar } });
                    if (respuestaBorrar === "ok") {
                        $("#" + respuesta[0].id + " td").fadeOut(1000);
                        toast({ msg: "Claustro borrado correctamente!", tipo: 'success' });
                        $('.modal-overlayClautro').hide();
                        $('.modalClautro').hide();
                    } else
                        toast({ msg: "Error al borrar un claustro! Error:" + respuestaBorrar.responseText, tipo: 'error' });
                });
                $("#editar").click(function () {
                    $("textarea").attr("readonly", false);
                    $("input").prop('disabled', false);
                });
                $("#guardar").click(function () {
                    var Gclaustro = {
                        "id": respuesta[0].id,
                        "titulo": $("#tituloEdit").val(),
                        "dia": $("#diaEdit").val(),
                        "primeraConvocatoria": $("#hiEdit").val(),
                        "segundaConvocatoria": $("#hfEdit").val(),
                        "curso": $("#cursoEdit").val(),
                        "orden": $("#orEdit").val(),
                        "observacion": $("#obEdit").val(),
                    };
                    console.log(Gclaustro);
                    let respuestaGuardar = peticionAjax({ url: "./librerias/php/funciones.php", tipo: "post", datos: { actualizarClaustro: Gclaustro } });
                    if (respuestaGuardar === "ok")
                        toast({ msg: "Claustro actualizado correctamente!", tipo: 'success' });
                    else
                        toast({ msg: "Error al actualizar un claustro! Error:" + respuestaGuardar.responseText, tipo: 'error' })
                });
            } else {
                toast({ msg: "Error inesperado. Error:" + respuestaTabla, tipo: 'error' })
                console.log('Error inesperado', respuestaTabla);
            };// fin Botón Atualizar Profes;// fin peticion ajax click en tabla
        });
    });// fin historico
});

