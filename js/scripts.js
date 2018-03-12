$(document).ready(function () {
    var profesPDF = [];
    //var $contenidoAjax = $('div#contenidoAjax').html('<p><img src="./src/loader.gif" /></p>');
    //al entrar en la web, actualizar profesor y desactivar los claustros activos.
    // $("#historico").hide();
    // $("#nuevo").hide();
    // $("#imprimir").hide();
    // $("#editar").hide();
    // $("#borrar").hide();
    // $("#guardar").hide();
    //$('div#contenidoAjax').hide();
    var crear = false;
    var claustroActivo = false;

    // Actualizar profes.
    //var datosProfesActualizar =  '< php echo json_encode($result); ?>';
    datosProfesActualizar = "datos";//JSON.parse(datosProfesActualizar);
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
    //Fin antes parche
    // NUEVO
    $("#btnNuevo").click(function () {
        $("#titulo").hide();
        $("#nuevo").show();
        $("#historico").hide();
        $("#selecProfe").change(function () {
            var str = "PROFESORES SELECCIONADOS:<br>";
            $("select option:selected").each(function () {
                str += $(this).text() + "<br>";
            });
            $("#seleccion").html("<div>" + str + "</div>");
        }).change();
        //comprobar si hay clautro activo para esa fecha.
        $("#fecha").focusout(function () {
            console.log("cambio fecha" + $("#fecha").val());
            $.ajax({
                url: "./librerias/php/funciones.php",
                type: 'post',
                dataType: 'json',
                data: { fecha: $("#fecha").val() },
                success: function (fecha) {
                    if (fecha == "ok") {
                        console.log("se puede crear!");
                    } else {
                        alert(fecha);
                        console.log("respuesta fecha " + fecha);
                    }
                }
            }).fail(function (error) {
                console.log(error);
            });
        });
    });// fin nuevo 

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

                //window.open(pdf, '_blank');
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
    $('#loginRegistro').click(function () {
        $('.login').css('display') == 'none' ? $('.login').css('display', 'block') : $('.login').css('display', 'none');
        $('.registro').css('display') == 'none' ? $('.registro').fadeIn() : $('.registro').fadeOut();
        $('.registro').css('display') == 'block' ? $('.registro').css('display', 'flex') : $('.registro').css('display', 'none');
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
    // CREAR NUEVO CLAUSTRO
    $("#crearClaustro").click(function () {
        //comprobar si hay clautro activo para esa fecha.     
        console.log("cambio fecha " + $("#fecha").val());
        debugger
        if ($("#tituloClaustro").val() == "" && $("#fecha").val() == "" && $("#horaInicio").val() == "" && $("#horaFin").val() == "" && $("#curso").val() == "" && $("#orden").val() == "") {
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
                    if ($("#tituloClaustro").val() == "" || $("#fecha").val() == "" || $("#horaInicio").val() == "" || $("#horaFin").val() == "" || $("#curso").val() == "" || $("#orden").val() == "" || profes.length <= 0) {
                        toast({ msg: "Relleno los campos: Título, día, Fecha, Hora Inicio, Hora Fin, Curso, Orden del Día y seleccione profesores.", tipo: 'warning' })
                    } else {
                        let claustro = {
                            "titulo": $("#tituloClaustro").val(),
                            "dia": $("#fecha").val(),
                            "horaInicio": $("#horaInicio").val(),
                            "horaFin": $("#horaFin").val(),
                            "curso": $("#curso").val(),
                            "orden": $("#orden").val(),
                            "observacion": $("#observacion").val(),
                            "profesores": profes
                        };
                        let creacionClaustro = peticionAjax({ url: "./librerias/php/funciones.php", tipo: "post", datos: { claustro: claustro } });
                        if (creacionClaustro == "ko") {
                            toast({ msg: "Ha habido algún error!" });
                        } else {
                            debugger
                            $("#tituloClaustro").val('');
                            $("#curso").val('');
                            $("#orden").val('');
                            $("#observacion").val('');
                            $("#fecha").val('');
                            $("#horaInicio").val('');
                            $("#horaFin").val('');
                            toast({ msg: "Creado correctamente! RECUERDE! sólo estará activo el mismo día!" });
                            $('.modal').hide();

                        }
                    }
                } else {
                    toast({ msg: "No se puede crear, revise el día" });
                    console.log("error-> " + respuesta);
                }
                $('#modalHistorico').modal();
            } else {
                toast({ msg: "Rellene el campo fecha" });
            }
        }
    });//fin botón CrearClaustro










    /**Comproar si hay claustro activo y cambiarlos de esteado  */
    // desactivar claustro activos.
    // $.ajax({
    //     url: "./librerias/php/funciones.php",
    //     type: 'post',
    //     dataType: 'json',
    //     data: { desactivar: "desactivar" },
    //     success: function (desactivar) {
    //         //alert(desactivar);
    //         if (desactivar == "ok") {
    //             claustroActivo = false;
    //             console.log("No hay claustro activo");
    //         } else {
    //             claustroActivo = true;
    //             console.log("Hay clautro activos " + desactivar);
    //         }
    //     }
    // }).fail(function (error) {
    //     console.log(error);
    // });
    // $("#reset").click(function () {
    //     location.reload();
    // });// fin desactivar Claustro activo

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
            tabla += "<tr id=" + respuesta[i].id + "><td>" + respuesta[i].titulo + "</td><td>" + respuesta[i].dia + "</td><td>" + respuesta[i].curso + "</td></tr>";
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
            // $("#imprimir").show();
            // $("#guardar").hide();
            // $("#editar").show();
            // $("#borrar").show();
            let x = $(this).parent("tr");
            let respuestaTabla = peticionAjax({ url: "./librerias/php/funciones.php", tipo: "post", datos: { historico: x.attr('id') } });
            if (respuestaTabla.status == 'ok') {
                debugger
                profesPDF = [];
                console.log("datos  ", respuestaTabla);
                let objeto = {};
                objeto.titulo = respuestaTabla.result[0].titulo;
                objeto.curso = respuestaTabla.result[0].curso;
                objeto.dia = respuestaTabla.result[0].dia;
                objeto.horaInicio = respuestaTabla.result[0].horaInicio;
                objeto.horaFin = respuestaTabla.result[0].horaFin;
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
                let objFirmas = {};
                $('.tablaFirmas').html("");
                for (let i = 0; i < respuestaTabla.result[1].length; i++) {
                    objFirmas.html = obtenerHTML('/ProyectoDawClaustro/porcionHtml.html?filaTablaFirma');
                    console.log("FIRMA", respuestaTabla.result[1][i].firma.length);
                    if (respuestaTabla.result[1][i].firma.length <= 23) {
                        objFirmas.nombre = [respuestaTabla.result[2][i].nombre];
                        //profesPDF.push([respuestaTabla.result[2][i].nombre]);
                    } else {
                        objFirmas.nombre = [respuestaTabla.result[2][i].nombre];
                        objFirmas.firma = [respuestaTabla.result[1][i].firma];
                        //profesPDF.push([respuestaTabla.result[2][i].nombre, respuestaTabla.result[1][i].firma]);
                    }
                    let cadenaFirmas = reemplazaMostachos(objFirmas);
                    $('.tablaFirmas').html(cadenaFirmas);
                }



                //datos = "<div id='datosPHP' class='row'>";
                // datos += "<div class='col'><p><label><strong>Titulo:&nbsp; </strong></label><input id='t' disabled value='" + respuesta[0].titulo + "'/></p></div>";
                // datos += '<div class="col"><p><label><strong>Curso:&nbsp; </strong></label><input id="c" disabled value="' + respuesta[0].curso + '"/></p></div><div class="col"><p><label><strong>Día:&nbsp; </strong></label><input id="d" disabled value="' + respuesta[0].dia + '"/></p></div>';
                // datos += '<div class="col"><p><label><strong>Hora Inicio:&nbsp; </strong></label><input id="hi" disabled value="' + respuesta[0].horaInicio + '"/></p></div><div class="col"><p><label><strong>Hora Fin:&nbsp; </strong></label><input id="hf" disabled value="' + respuesta[0].horaFin + '"/></p></div>';
                // datos += '<div class="col"><p class="lead"><strong>Orden del día: </strong><article><textarea id="or" rows="4"  cols="75" readonly >' + respuesta[0].orden + '</textarea></article></p></div><div class="col"><p class="lead"><strong>Observaciones realizadas: </strong><article><textarea id="ob" rows="4"  cols="75" readonly >' + respuesta[0].observacion + '</textarea></article></p></div>';
                // datos += "</div><div class='row'><div class='col'><strong>Número de Profesores asistentes: </strong><br><div STYLE='background-color:WHITE' align='center'><table cellspacing='10' cellpadding='pixels' border='1px' style=' width: 100%'>";
                //*********************************************falta intertar tabla dentro de modal
                // for (let i = 0; i < respuesta[1].length; i++) {
                //     console.log("FIRMA", respuesta[1][i].firma.length);
                //     if (respuesta[1][i].firma.length <= 23) {
                //         profesPDF.push([respuesta[2][i].nombre]);
                //     } else {
                //         profesPDF.push([respuesta[2][i].nombre, respuesta[1][i].firma]);
                //     }
                //     datos += '<tr><td align="center" valign="middle" style="font-weight:bold">  ' + respuesta[2][i].nombre + '  </td><td align="center" valign="middle"> <img src="' + respuesta[1][i].firma + '" alt="Sin Firma" width="100" height="50"></td></tr>';
                // }
                // datos += "</table></div></div>";
                // $("#datosClaustroHistorico").html(datos);
                // para evitar problemas con id
                $("#borrar").off("click");
                // si hace click en borrar!
                $("#borrar").click(function () {
                    console.log("dentro de borrar, id:", respuesta[0].id);
                    $.ajax({
                        url: "./librerias/php/funciones.php",
                        type: 'post',
                        dataType: 'json',
                        data: { borrar: respuesta[0].id },
                        success: function (r) {
                            if (r == "ok") { //respuesta[0].id
                                $("#" + respuesta[0].id + " td").fadeOut(1000);
                                $("#datosClaustroHistorico").html("");
                                $("#editar").hide();
                                $("#borrar").hide();
                                $("#guardar").hide();
                                $("#imprimir").hide();
                                alert("borrado correctamente!");
                            } else alert("Error al borrar un claustro! id: " + r);
                        },
                        error: function (xhr, status, error) {
                            alert(xhr.responseText);
                            console.log(xhr, status, error);
                        }
                    }).fail(function (error) {
                        console.log(error);
                    });
                });
                $("#editar").click(function () {
                    $("#guardar").show();
                    $("textarea").attr("readonly", false);
                    $("input").prop('disabled', false);
                });
                $("#guardar").click(function () {
                    var Gclaustro = {
                        "id": respuesta[0].id,
                        "titulo": $("#tituloEdit").val(),
                        "dia": $("#diaEdit").val(),
                        "horaInicio": $("#hiEdit").val(),
                        "horaFin": $("#hfEdit").val(),
                        "curso": $("#cursoEdit").val(),
                        "orden": $("#orEdit").val(),
                        "observacion": $("#obEdit").val(),
                    };
                    console.log(Gclaustro);
                    // falta el selct con los profes
                    $.ajax({
                        url: "./librerias/php/funciones.php",
                        type: 'post',
                        dataType: 'json',
                        data: { actualizarClaustro: Gclaustro },
                        success: function (respuesta) {
                            if (respuesta == "ok") {
                                alert("Actualizado correctamente!");
                            } else alert("Error al crear un claustro!");
                        }
                    });
                });
            } else {
                debugger
                console.log('Error', respuestaTabla);
            };// fin Botón Atualizar Profes;// fin peticion ajax click en tabla
        });
    });// fin historico
});

