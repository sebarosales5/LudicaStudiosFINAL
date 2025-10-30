// Reabrir offcanvas y modal si hay error de registro/login
// y mostrar toast de éxito si corresponde.

document.addEventListener('DOMContentLoaded', () => {
  // Mostrar toast de éxito si existe
  if (typeof showSuccessToast !== 'undefined' && showSuccessToast === true) {
    const toastElement = document.getElementById('successToast');
    const toastBody = document.getElementById('toastMessage');

    if (toastElement && toastBody && typeof successMessage !== 'undefined') {
      toastBody.textContent = successMessage;
      const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 4000,
      });
      toast.show();
    }
  }

  const urlParams = new URLSearchParams(window.location.search);
  const hasError = urlParams.get('error');

  if (hasError === '1') {
    // Abrir el offcanvas
    const offcanvasElement = document.getElementById('offcanvasExample');
    if (offcanvasElement) {
      const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
      offcanvas.show();
    }

    // Abrir el modal
    const modalElement = document.getElementById('formularioModal');
    if (modalElement) {
      const modal = new bootstrap.Modal(modalElement);
      modal.show();

      // Activar la pestaña correcta según el tipo de error
      if (typeof errorType !== 'undefined') {
        setTimeout(() => {
          if (errorType === 'login') {
            const loginTab = document.getElementById('login-tab');
            if (loginTab) {
              const tab = new bootstrap.Tab(loginTab);
              tab.show();
            }
          } else if (errorType === 'registro') {
            const registroTab = document.getElementById('registro-tab');
            if (registroTab) {
              const tab = new bootstrap.Tab(registroTab);
              tab.show();
            }
          }
        }, 100);
      }
    }

    // Limpiar el parámetro error de la URL sin recargar
    window.history.replaceState({}, document.title, window.location.pathname);
  }

  // Validación de registro en el cliente: no cierra el modal ni cambia de pestaña
  const registroPane = document.querySelector('#registro');
  const form = registroPane ? registroPane.querySelector('form') : null;
  if (!form) return;

  function removeClientAlert() {
    const old = registroPane.querySelector('.client-alert');
    if (old) old.remove();
  }

  form.addEventListener('submit', (e) => {
    removeClientAlert();

    const nameInput = form.querySelector('input[name="nombre"]');
    const emailInput = form.querySelector('input[name="correo"]');
    const passInput = form.querySelector('input[name="contrasena"]');

    // Normalizar nombre (solo trim, espacios no permitidos)
    const nameRaw = nameInput.value || '';
    const nameNorm = nameRaw.trim();
    nameInput.value = nameNorm; // reflejar normalización visualmente

    // Regla de caracteres permitidos: letras (incluye acentos), números, punto, guion y guion bajo (SIN espacios)
    const invalidCharRegex = /[^\p{L}0-9._\-]/u;

    const errors = [];
    // Validar espacios sobre el valor RAW para capturar espacios al inicio/fin
    if (/\s/.test(nameRaw)) {
      errors.push('El nombre no puede contener espacios.');
    }
    if (invalidCharRegex.test(nameNorm)) {
      errors.push('El nombre contiene caracteres no permitidos. Permitidos: letras, números, punto, guion y guion bajo.');
    }
    if (nameNorm.length < 3 || nameNorm.length > 50) {
      errors.push('El nombre debe tener entre 3 y 50 caracteres.');
    }

    const email = (emailInput.value || '').trim().toLowerCase();
    // Validación simple de email + longitud
    const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) && email.length <= 100;
    if (!emailOk) {
      errors.push('Ingresá un correo válido (máx. 100 caracteres).');
    }

    const pass = (passInput.value || '').trim();
    if (pass.length < 6 || pass.length > 100) {
      errors.push('La contraseña debe tener entre 6 y 100 caracteres.');
    }

    if (errors.length) {
      e.preventDefault(); // no enviar, mantener modal abierto
      // Marcar inputs
      nameInput.classList.toggle('is-invalid', true);
      emailInput.classList.toggle('is-invalid', true);
      passInput.classList.toggle('is-invalid', true);

      // Mostrar alerta dentro del tab de registro
      const alertDiv = document.createElement('div');
      alertDiv.className = 'alert alert-danger client-alert';
      alertDiv.setAttribute('role', 'alert');
      alertDiv.innerHTML = '<strong>No se pudo registrar:</strong><ul class="mb-0">' + errors.map(m => `<li>${m}</li>`).join('') + '</ul>';
      registroPane.insertBefore(alertDiv, form);
    } else {
      // Limpiar marcas de error si todo está OK
      [nameInput, emailInput, passInput].forEach(i => i.classList.remove('is-invalid'));
    }
  });

  // Eliminamos alerta cuando el usuario corrige algo
  registroPane.addEventListener('input', removeClientAlert);
});
