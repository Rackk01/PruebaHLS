let formulario = document.getElementById("formulario");


formulario.addEventListener("submit", function(event){
    event.preventDefault();

    let datos =  new FormData(formulario);

    console.log(datos)
    console.log(datos.get("usuario"))
    console.log(datos.get("pass"))

    fetch("formulario.php",{
        method: "POST",
        body: datos
    })

    .then(res => res.json)
    .then(data => {
        console.log(data)

    })
})