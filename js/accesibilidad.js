window.onload = function() {
  const botones = document.querySelectorAll('.button.is-danger');

  botones.forEach(boton => {
    boton.onclick = function() {
      if (confirm('¿Deseas eliminar este elemento?')) {
        this.closest('.col-md-3').remove();
      }
    };
  });


  document.querySelectorAll('.button.is-warning').forEach(boton => {
    boton.onclick = function() {
      const card = this.closest('.card');
      if (card.querySelector('.form-editar')) return;

      const form = document.createElement('div');
      form.className = 'form-editar';
      form.innerHTML = `
        <p><b>Editar producto</b></p>
        <input type="text" placeholder="Nuevo nombre"><br><br>
        <input type="number" placeholder="Nuevo precio"><br><br>
        <input type="file" accept="image/*"><br><br>
        <button class="guardar">Guardar</button>
        <button class="cancelar">Cancelar</button>
      `;

      card.appendChild(form);

      form.querySelector('.cancelar').onclick = () => form.remove();
      form.querySelector('.guardar').onclick = () => {
        alert('Simulación: producto editado.');
        form.remove();
      };
    };
  });
};