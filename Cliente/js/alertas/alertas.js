//obtenenos el parametro de la url  llamado resultado
const urlParams = new URLSearchParams(window.location.search);
const resultado = urlParams.get("resultado");

function limpiarparametros() {
    window.history.replaceState("", document.title, window.location.pathname);
}
//alerta de poliza insertada
if (resultado == "Polizainsertada") {
  Swal.fire({
    title: "Insertado correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta tenencia insertada correctamente
if (resultado == "Tenenciainsertada") {
  Swal.fire({
    title: "Tenencia insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta tenencia actualizada correctamente
if (resultado == "Teneciactualizada") {
  Swal.fire({
    title: "Tenencia actualizada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de verificacion insertada correctamente
if (resultado == "Verificacioninsertada") {
  Swal.fire({
    title: "Verificacion insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de verificacion actualizada correctamente
if (resultado == "Verificacionactualizada") {
  Swal.fire({
    title: "Verificacion actualizada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de unidad insertada
if (resultado == "Unidadinsertada") {
  Swal.fire({
    title: "Unidad insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de poliza actualizada
if (resultado == "Polizactualizada") {
  Swal.fire({
    title: "Póliza actualizada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de unidad actualizada
if (resultado == "Unidadactualizada") {
  Swal.fire({
    title: "Unidad actualizada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta para que no se asigne la unidad si no hay licencia de conducir
if (resultado == "SinLicencia") {
  Swal.fire({
    title: "El colaborador no tiene licencia de conducir, está vencida o inactiva",
    text: "Operación no realizada",
    icon: "error",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de responsiva enviada
if (resultado == "Responsivaenviada") {
  Swal.fire({
    title: "Unidad asignada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta para enviar la responsiva firmada
if (resultado == "Responsivaenviadayfirmada") {
  Swal.fire({
    title: "Responsiva enviada correctamente.",
    text: "Espera a que validen tu firma",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de responsiva denegada
if (resultado == "Responsivadenegada") {
  Swal.fire({
    title: "Responsiva denegada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de responsiva aprobada
if (resultado == "Responsivaaprovada") {
  Swal.fire({
    title: "Responsiva aprobada correctamente",
    text: "Acción realizada correctamente.",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de comodato enviado
if (resultado == "Comodatoenviado") {
  Swal.fire({
    title: "Acción realizada",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de comodato aceptado
if (resultado == "Comodatoaprovado") {
  Swal.fire({
    title: "Comodato aprobado correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de comodato denegado
if (resultado == "Comodatodenegado") {
  Swal.fire({
    title: "Comodato denegado correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de comodato regresado por parte del usuario a juridico
if (resultado == "Comodatoregresadoajuridico") {
  Swal.fire({
    title: "Comodato regresado correctamente",
    text: "Espera a que el equipo jurídico realice el cambio",
    icon: "success",
    confirmButtonText: "Aceptar",
  }); 

  limpiarparametros();
}
//alerta de solicitud de unidad pool por parte del ususario
if (resultado == "Solicitudunidadpool") {
  Swal.fire({
    title: "Solicitud realizada correctamente",
    text: "Descarga y firma tu carta responsiva.",
    icon: "success",
    confirmButtonText: "Aceptar",
  }); 

  limpiarparametros();
}
//alerta de licencia de conducir insertada
if (resultado == "licenciasinsertada") {
  Swal.fire({
    title: "Licencia de conducir insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de notificacion enviada a el ususario para que pueda firmar el comodato
if (resultado == "Notificaciónenviada") {
  Swal.fire({
    title: "Notificación enviada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//Alerta comprobante de domicilio insertado 
if (resultado == "comprobantedomicilioinsertado") {
  Swal.fire({
    title: "Comprobante de domicilio insertado correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//Alerta persona fisica insertada
if (resultado == "personafisicainsertada") {
  Swal.fire({
    title: "Persona física insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta ine insertada
if (resultado == "ineinsertado") {
  Swal.fire({
    title: "INE insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//Alerta de constancia de situacion fscal insertada
if (resultado == "constanciafiscalinsertada") {
  Swal.fire({
    title: "Constancia de situación fiscal insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de persona fisica actualizada correctamente
if (resultado == "personafisicaactualizada") {
  Swal.fire({
    title: "Persona fisica actualizada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de persona moral insertada correctamente
if (resultado == "AltaPersonamoralExitosa") {
  Swal.fire({
    title: "Persona moral insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de persona moral actualizada correctamente
if (resultado == "Solicitudunidaddemo") {
  Swal.fire({
    title: "Solicitud realizada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de unidad demo autorizada
if (resultado == "Autorizacionunidademo") {
  Swal.fire({
    title: "Unidad demo autorizada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  limpiarparametros();
}
//alerta de prueba demo insertada
if (resultado == "pruebasinsertadas") {
  Swal.fire({
    title: "Prueba demo insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });
}
//alerta para finalizar pruebas demos
if (resultado == "pruebafinalizada") {
  Swal.fire({
    title: "Pruebas finalizadas correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });
} 
//alerta para asignar Master Driver
if (resultado == "MasterDriverAsignado") {
  Swal.fire({
    title: "Máster Driver asignado correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });
  limpiarparametros();
}
//alerta para insertar la prueba final demo
if (resultado == "reporteinsertado") {
  Swal.fire({
    title: "Prueba final demo insertada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });
  limpiarparametros();
}
//alerta para finalizar la prueba demo y solicitar la baja
if (resultado == "pruebaterminada") {
  Swal.fire({
    title: "Prueba finalizada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });
  limpiarparametros();
}
//alerta de prorroga unidad demo
if (resultado == "prorrogaenviada") {
  Swal.fire({
    title: "Prórroga solicitada correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });
  limpiarparametros();
}
//alerta de comodato firmado demo
if (resultado == "Comodatodemosubido") {
  Swal.fire({
    title: "Comodato subido correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });
  limpiarparametros();
}
//alerta observaciones de documentos solicitantes demos
if (resultado == "Observaciones") {
  Swal.fire({
    title: "Observaciones enviadas correctamente",
    text: "Operación realizada correctamente",
    icon: "success",
    confirmButtonText: "Aceptar",
  });
  limpiarparametros();
}