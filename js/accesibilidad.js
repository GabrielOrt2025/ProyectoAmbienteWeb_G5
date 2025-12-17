window.onload = function() {
  const botones = document.querySelectorAll('.button.is-danger');

  botones.forEach(boton => {
    boton.onclick = function() {
      if (confirm('¿Deseas eliminar este elemento?')) {
        this.closest('.col-md-3').remove();
      }
    };
  });

  //Queryselectorall nos ayuda a que se tomen en cuenta todos los botones de editar para activar el script
  document.querySelectorAll('.button.is-warning').forEach(boton => {
    boton.onclick = function() {
    //variable que localiza el card en la que se quiere hacer el cambio
      const producto = this.closest('.card');
      if (producto.querySelector('.form-editar')) return;
        //Se crea un formulario a partir de la variable formulario usando html interno
      const formulario = document.createElement('div');
      formulario.className = 'formulario-editar';
      formulario.innerHTML = `
        <p><b>Editar producto</b></p>
        <input type="text" placeholder="Nombre"><br><br>
        <input type="number" placeholder="Precio"><br><br>
        <input type="file" accept="image/*"><br><br>
        <button class="guardar">Guardar</button>
        <button class="cancelar">Cancelar</button>
      `;
    //appendchild hace que el formulario aparezca dentro del mismo card
      card.appendChild(formulario);
        //si se hace click en el boton cancelar, solo se cierra el formulario con formulario.remove
      formulario.querySelector('.cancelar').onclick = () => formulario.remove();
      //Si se hace click en el boton guardar, se actualiza la información nueva
      formulario.querySelector('.guardar').onclick = () => {
        alert('producto editado correctamente');
        formulario.remove();
      };
    };
  });
};