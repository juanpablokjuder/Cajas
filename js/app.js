function tipoOperacion(id,button){
    //setiar todos los botones en black
    const bComprar = document.getElementById("bComprar")
    const bVender = document.getElementById("bVender")
    const bIngreso = document.getElementById("bIngreso")
    const bEgreso = document.getElementById("bEgreso")
    const bPerso = document.getElementById("bPerso")

    bComprar.style.boxShadow ="";
    bVender.style.boxShadow ="";
    bIngreso.style.boxShadow ="";
    bEgreso.style.boxShadow ="";
    bPerso.style.boxShadow ="";



    const div = document.getElementById(id);
    const cont = document.getElementById("contIngresos");
    for(let i=0;i<cont.children.length;i++){
        cont.children[i].style.display="none";
    }
    div.style.display= "BLOCK"
    document.getElementById(button).style.boxShadow = "0px 0px 2px 1px rgb(148, 148, 148) inset"
}

setTimeout(()=>{
    let error = document.getElementById("error");
    error.style.display = "none";
},5000)