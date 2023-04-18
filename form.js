const formulario = document.getElementById("formulario");

formulario.addEventListener("submit", function (event) {
  event.preventDefault();

  let datos = new FormData(formulario);

  if(datos.get("usuario").trim() === '' || datos.get("pass").trim() === ''){
    Swal.fire({
      icon: 'error',
      title: 'Oops... Ha ocurrido un error',
      text: 'Revisa que los datos ingresados sean correctos!',
      footer: '<a href="">Why do I have this issue?</a>'
    })
    return;
  }else{
    Swal.fire(
      'Excelente!',
      'Buen trabajo!',
      'success'
    )
  }

  loginUser(datos.get("usuario"), datos.get("pass"));
});

const loginUser = async (email, pass) => {
  let formData = new FormData();

  formData.append("email", email);
  formData.append("pass", pass);

  try {
    const res = await fetch("http://localhost/PruebaHLS/formulario.php", {
      method: "POST",
      body: formData,
    });

    const data = await res.json();
    // console.log(typeof(data));
    console.log(data);

    if (data.success) {

        Swal.fire({
          icon: 'success',
          title: 'Bien hecho',
          text: 'Has ingresado correctamente!',
          footer: '<a href="">Why do I have this issue?</a>'
        })

    }else{
      Swal.fire({
        icon: 'error',
        title: data.message,
        text: 'Revisa que los datos ingresados sean correctos!',
        footer: '<a href="">Why do I have this issue?</a>'
      })
    }
  } catch (error) {
    console.log(error);
  }
};



// saludo('MAÑANAS');

// function saludo(parteDelDia){
//     console.log("BUENAS " + parteDelDia);
// }
