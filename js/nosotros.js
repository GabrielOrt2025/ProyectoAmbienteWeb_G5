
window.onload = function() { //el sentido de estos scrips es para que cada clase php tenga interactividad propia, aqui esperamos a que cargue
     

    const elementos = document.querySelectorAll('.valor-card, .historia-content'); // esta parte se selecciono los elementos que se quieren animar
    
    function verificarVisibilidad() {//como lo dice el nombre, verifica si los elementos estan visibles
        for (var i = 0; i < elementos.length; i++) {// // este for pasa por todos los elementso
            var elemento = elementos[i];
            
            var posicion = elemento.getBoundingClientRect();//aqui da la posicion del elemento
            
            var estaVisible = posicion.top < window.innerHeight && posicion.bottom >= 0;// se fija si el elemento esta visible
            
            if (estaVisible) {// en este casi si.. si esta visible se haria un if
                elemento.style.opacity = '1';
                elemento.style.transform = 'translateY(0)';
            }
        }
    }
    
    for (var i = 0; i < elementos.length; i++) { // aqui se inicia con los elementos en estado invisible
        elementos[i].style.opacity = '0';
        elementos[i].style.transform = 'translateY(20px)';
        elementos[i].style.transition = 'all 0.6s ease';
    }
    
    verificarVisibilidad();
    
    window.addEventListener('scroll', verificarVisibilidad); // ahora se fija se esta visible y se puede hacer scroll
    
    
    // esto se encarga de que nos de el efecto para que nos lleve a motivacion,vision y innovacion
    
    var valorCards = document.querySelectorAll('.valor-card');
    var contadorActivado = false;
    
    function animarValores() { // esta funcion se fija si las tarjetas de valores estan visibles
        
        if (valorCards.length > 0) {
            var posicion = valorCards[0].getBoundingClientRect(); // se fija si ya lo logramos ver
            
            if (posicion.top < window.innerHeight && !contadorActivado) {
                contadorActivado = true;
                
               
                for (var i = 0; i < valorCards.length; i++) { //recorre cada tarjeta
                    (function(index) {
                        setTimeout(function() {
                            valorCards[index].style.opacity = '1';
                            valorCards[index].style.transform = 'scale(1)';
                        }, index * 200);
                    })(i);
                }
            }
        }
    } 
    for (var i = 0; i < valorCards.length; i++) {
        valorCards[i].style.opacity = '0';
        valorCards[i].style.transform = 'scale(0.9)';
        valorCards[i].style.transition = 'all 0.5s ease';
    }
    
    window.addEventListener('scroll', animarValores);
    
    
    // este de abajo es cuando le damos "conocer mas" nos manda hacia la parte de historia
    
    var btnConocer = document.querySelector('.btn-conocer');
    
    if (btnConocer) { // se fija si el boton existe
        
        btnConocer.onclick = function(e) {
            e.preventDefault(); // evita que el enlace funcione normalmente
            
            var destino = document.querySelector('#historia');// Bbuca la parte del destino o sea la historia
            
            if (destino) {//ya aqui se aplica el scroll suave
                destino.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        };
    }
    
    
};