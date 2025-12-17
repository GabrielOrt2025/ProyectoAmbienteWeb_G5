 document.getElementById("loginForm").addEventListener("submit", function(e) {// se fija que el frormulario se envie bap bap
      var email = document.getElementById("email").value;
      
      if (email === "") {// en este caso solo se valida que el campo no este vacio
        e.preventDefault();
        mostrarError("Por favor, ingresa tu email"); //muestra el error
      }
    });
    
    function mostrarMensaje(tipo) {// esta funcion haria que se muesten mensajes  
      if (tipo === 'recuperar') {
        alert("Proximamente:Recuperacion de contraseña");
      } else if (tipo === 'activar') {
        alert("Proximamente: Activacion de cuenta");
      }
    }
    
    function mostrarError(mensaje) {// en caso de que haya un error, mueste el mensaje
      var errorDiv = document.createElement("div");
      errorDiv.className = "error-message";
      errorDiv.id = "errorMsg";
      errorDiv.innerHTML = mensaje;
      
      var form = document.getElementById("loginForm");
      form.insertBefore(errorDiv, form.firstChild);
      
      setTimeout(function() {//este es para que oculte los mensaje despues de 3 segundos
        errorDiv.style.display = "none";
      }, 3000);
    }
