/* ============================================================
   custom.js — Farmacia SV · Mejoras UX
   Incluir ANTES de </body> en footer.php:
   <script src="custom.js"></script>
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ── 1. Confirmar eliminación con modal nativo mejorado ─── */
  document.querySelectorAll('a[href*="eliminar_registro"]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const url = btn.getAttribute('href');
      if (window.confirm('¿Seguro que deseas eliminar este registro? Esta acción no se puede deshacer.')) {
        window.location.href = url;
      }
    });
  });

  /* ── 2. Auto-ocultar alertas después de 4 segundos ─────── */
  document.querySelectorAll('.alert').forEach(function (alert) {
    setTimeout(function () {
      alert.style.transition = 'opacity 0.5s ease, margin 0.5s ease, padding 0.5s ease';
      alert.style.opacity = '0';
      alert.style.marginBottom = '0';
      alert.style.padding = '0';
      setTimeout(function () { alert.remove(); }, 500);
    }, 4000);
  });

  /* ── 3. Resaltar fila activa al pasar el cursor ─────────── */
  document.querySelectorAll('tbody tr').forEach(function (row) {
    row.style.transition = 'background 0.1s';
  });

  /* ── 4. Feedback visual en botones submit ───────────────── */
  document.querySelectorAll('button[type="submit"]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const form = btn.closest('form');
      if (form && form.checkValidity()) {
        btn.disabled = true;
        const original = btn.textContent;
        btn.textContent = 'Procesando...';
        btn.style.opacity = '0.7';
        // Restaurar si hay error de validación del servidor (recarga)
        setTimeout(function () {
          btn.disabled = false;
          btn.textContent = original;
          btn.style.opacity = '1';
        }, 8000);
      }
    });
  });

  /* ── 5. Búsqueda en tiempo real sobre la tabla ──────────── */
  const table = document.querySelector('table');
  if (table) {
    // Crear input de búsqueda
    const wrapper = document.createElement('div');
    wrapper.style.cssText = 'margin-bottom:14px;';

    const input = document.createElement('input');
    input.type = 'text';
    input.placeholder = 'Buscar en la tabla...';
    input.className = 'form-control';
    input.style.cssText = 'max-width:280px;font-size:13px;';

    wrapper.appendChild(input);
    table.parentNode.insertBefore(wrapper, table);

    input.addEventListener('input', function () {
      const term = input.value.toLowerCase().trim();
      const rows = table.querySelectorAll('tbody tr');
      rows.forEach(function (row) {
        const text = row.textContent.toLowerCase();
        row.style.display = (!term || text.includes(term)) ? '' : 'none';
      });
    });
  }

  /* ── 6. Mostrar/ocultar contraseña en login y registro ──── */
  document.querySelectorAll('input[type="password"]').forEach(function (input) {
    const wrapper = document.createElement('div');
    wrapper.style.cssText = 'position:relative;';
    input.parentNode.insertBefore(wrapper, input);
    wrapper.appendChild(input);

    const toggle = document.createElement('button');
    toggle.type = 'button';
    toggle.textContent = '👁';
    toggle.title = 'Mostrar / ocultar contraseña';
    toggle.style.cssText = [
      'position:absolute',
      'right:10px',
      'top:50%',
      'transform:translateY(-50%)',
      'background:none',
      'border:none',
      'cursor:pointer',
      'font-size:14px',
      'opacity:0.5',
      'padding:0',
      'line-height:1',
    ].join(';');

    toggle.addEventListener('click', function () {
      input.type = input.type === 'password' ? 'text' : 'password';
      toggle.style.opacity = input.type === 'text' ? '1' : '0.5';
    });

    wrapper.appendChild(toggle);
  });

});
