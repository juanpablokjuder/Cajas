<script>
function agregarAccesoDirecto() {
    if (window.navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
        // Para iOS
        var nombre = "Mi Sitio Web";
        var url = "https://www.tusitio.com";
        var icono = "https://www.tusitio.com/icono.png"; // URL del icono que deseas usar

        if (window.navigator.standalone) {
            alert("Este dispositivo ya está en la pantalla de inicio.");
        } else {
            if (confirm("¿Deseas agregar " + nombre + " a la pantalla de inicio?")) {
                var metaTag = document.createElement('meta');
                metaTag.name = "apple-mobile-web-app-capable";
                metaTag.content = "yes";
                document.getElementsByTagName('head')[0].appendChild(metaTag);
                
                var linkTag = document.createElement('link');
                linkTag.rel = "apple-touch-icon";
                linkTag.href = icono;
                document.getElementsByTagName('head')[0].appendChild(linkTag);
                
                var linkTag2 = document.createElement('link');
                linkTag2.rel = "apple-touch-startup-image";
                linkTag2.href = icono; // Puedes utilizar otra imagen si deseas
                document.getElementsByTagName('head')[0].appendChild(linkTag2);
                
                var aTag = document.createElement('a');
                aTag.href = url;
                aTag.innerHTML = "Haz clic aquí para abrir " + nombre;
                document.body.appendChild(aTag);
            }
        }
    } else {
        alert("Este método solo es compatible con dispositivos iOS.");
    }
}
</script>
<script>
function agregarAccesoDirecto2() {
    var nombre = "Mi Sitio Web";
    var url = "https://www.tusitio.com";
    var icono = "https://www.tusitio.com/icono.png"; // URL del icono que deseas usar

    if ("addToHomescreen" in window && window.addToHomescreen.isCompatible) {
        // Para Android con la librería addToHomescreen.js
        window.addToHomescreen({
            autostart: false,
            startDelay: 0,
            lifespan: 0,
            touchIcon: true,
            message: 'Instala ' + nombre + ' en tu pantalla de inicio. Toca %icon y luego "Agregar a pantalla de inicio".'
        });
    } else {
        alert("Este dispositivo no es compatible con la creación de accesos directos.");
    }
}
</script>

<button onclick="agregarAccesoDirecto2()">Crear Acceso Directo</button>

<script src="addToHomescreen.min.js"></script> <!-- Asegúrate de tener esta librería agregada -->
