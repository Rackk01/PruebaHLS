const formulario = document.getElementById("formulario");

formulario.addEventListener("submit", function (event) {
  event.preventDefault();

  let datos = new FormData(formulario);

  if(datos.get("usuario").trim() === '' || datos.get("pass").trim() === '' || datos.get("newPass").trim() === '' || datos.get("repNewPass").trim() === ''){
    MostrarMensaje('error','Oops... Ha ocurrido un error','Ten cuidado con dejar campos vacíos!!');
    return;

  }
  else{
    // MostrarMensaje('success','GENIO','Ingresaste correctamente los datos!!');
  }
  
  updateUser(datos.get("usuario"), datos.get("pass"), datos.get("newPass"), datos.get("repNewPass"));

});

const updateUser = async (email, pass, newPass, repNewPass) => {
  let formData = new FormData();
console.log(newPass)
  formData.append("email", email);
  formData.append("pass", pass);
  formData.append("newPass", newPass);
  formData.append("repNewPass", repNewPass);
  formData.append("funcion", "updateUser");
  
  try {
    const res = await fetch("http://localhost/PruebaHLS/update/formupdate.php", {
      method: "POST",
      body: formData,
    });

    const data = await res.json();
    console.log(data);

    const alerta = document.getElementById("alerta");

    if (data.success) {

      // Mensaje estatico SUCCESS por registro exitoso del usuario en la DB
      alerta.textContent = data.goodmessage;
      alerta.classList.remove("alert-danger");
      alerta.classList.add("alert-success");

      // Mensaje pop-up SUCCESS por registro exitoso del usuario en la DB
      Swal.fire({
  
        icon: 'success',
        title: data.goodmessage,
        text: 'Has iniciado correctamente',
      })
    } else {

      // Mensaje de ERROR estatico por usuario ya registrado en la DB
      alerta.textContent = data.message;
      alerta.classList.remove("alert-success");
      alerta.classList.add("alert-danger");

      Swal.fire({

        // Mensaje pop-up ERROR por usuario ya registrado en la DB
  
        icon: 'error',
        title: data.message,
        text: 'Intente con otro usuario',
      })

    }

    // Mostrar la alerta
    alerta.classList.remove("d-none");

    // Ocultar la alerta después de 7 segundos
    setTimeout(() => {
      alerta.classList.add("d-none");
    }, 7000);

  } catch (error) {
    console.log(error);
  }
};


function MostrarMensaje(icono, titulo, texto){
  const alerta = document.getElementById("alertaInfo");

  Swal.fire({      
    // Mensaje pop-up de error por inputs vacios (mensaje manual)
    icon: icono,
    title: titulo,
    text: texto,
  });

  // 1 Mostrar el alert bootstrap con las clases y mensajes correspondientes

  if (icono == "error"){

    console.log("es error")

    alerta.textContent = texto;
    alerta.classList.remove("alert-success");
    alerta.classList.remove("alert-info");
    alerta.classList.add("alert-danger");

    document.getElementById('idParrafo').innerHTML = texto;
  } else{

    alerta.textContent = texto;
    alerta.classList.remove("alert-danger");
    alerta.classList.remove("alert-info");
    alerta.classList.add("alert-success");
  }

  //Mostrar la alerta en pantalla
  alerta.classList.remove("d-none");

    //Ocultar la alerta después de 7 segundos
    setTimeout(() => {
      alerta.classList.add("d-none");
    }, 7000);


}

