const formulario = document.getElementById("formulario");

formulario.addEventListener("submit", function (event) {
  event.preventDefault();

  let datos = new FormData(formulario);

  if(datos.get("usuario").trim() === '' || datos.get("pass").trim() === ''){
    Swal.fire({
      icon: 'error',
      title: 'Oops... Ha ocurrido un error',
      text: '!',
      footer: '<a href="">Why do I have this issue?</a>'
    })
    return;
  }else{
    Swal.fire(
      'Excelente!',
      'Te has logueado con exito!',
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

    const data = await res.text();
    // console.log(typeof(data));
    console.log(data);

    if (data == "success") {

    }
  } catch (error) {
    console.log(error);
  }
};



// saludo('MAÑANAS');

// function saludo(parteDelDia){
//     console.log("BUENAS " + parteDelDia);
// }
