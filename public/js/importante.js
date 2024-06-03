//VER CONTRASEÑA
// import swal from 'sweetalert';

function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const showPasswordIcon = document.getElementById("show-password");
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);

    // Cambiar el ícono del ojo
    const eyeIconClass = type === "password" ? "fa-eye-slash" : "fa-eye";
    showPasswordIcon.classList.remove("fa-eye-slash", "fa-eye");
    showPasswordIcon.classList.add(eyeIconClass);
}

// DNI
function validarDocumento(input) {
    let valor = input.value.replace(/\D/g, '');
    valor = valor.slice(0, 8);
    input.value = valor;
}

//CODIGO
function validarDocumento1(input) {
    let valor = input.value.replace(/\D/g, '');
    valor = valor.slice(0, 11);
    input.value = valor;
}

//TELEFONO
function validarTelefono(input) {
    let valor = input.value.replace(/\D/g, '');
    valor = valor.slice(0, 9);
    input.value = valor;
}

//NOMBRES

function validarLetras(input) {
    // Eliminar caracteres no válidos y convertir a mayúsculas
    input.value = input.value.replace(/[^A-Za-z\s]/g, '').toUpperCase();
}



//DIRECCION
function convertirMayusculas(input) {
    input.value = input.value.toUpperCase();
}



//CATEGORIA
function validarLetras2(event) {
    const input = event.target;
    const valor = input.value;
    const letras = /^[a-zA-Z]+$/;

    if (!letras.test(valor)) {
        input.value = valor.slice(0, -1);
    }
}

function validarEntrada(input) {
    input.value = input.value.replace(/[^0-9.]/g, '');
}

function convertirNumeroALetras() {
    const input = document.getElementById('numeroDecimal').value;
    const textarea = document.getElementById('resultado');
    const numero = parseFloat(input);

    if (isNaN(numero)) {
        textarea.value = '';
        return;
    }

    const partes = input.split('.');
    const gramos = parseInt(partes[0]) || 0;
    const centigramos = partes[1] ? parseInt(partes[1].padEnd(2, '0')) : 0;

    let resultadoEnLetras = '';

    resultadoEnLetras += convertirNumero(gramos) + ' ' + (gramos === 1 ? 'GRAMO' : 'GRAMOS') + ' ';
    resultadoEnLetras += convertirCentigramos(centigramos) + ' CENTIGRAMOS DE ALCOHOL POR LITRO DE SANGRE';

    textarea.value = resultadoEnLetras.toUpperCase();
}

function convertirNumero(numero) {
    const unidades = ['CERO', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
    const decenas = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
    const decenas2 = ['VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];

    if (numero < 10) {
        return unidades[numero];
    } else if (numero < 20) {
        return decenas[numero - 10];
    } else if (numero < 100) {
        const unidad = numero % 10;
        const decena = Math.floor(numero / 10);
        if (unidad === 0) {
            return decenas2[decena - 2];
        } else {
            return decenas2[decena - 2] + ' Y ' + unidades[unidad];
        }
    } else {
        return numero.toString();
    }
}

function convertirCentigramos(centigramos) {
    const unidades = ['CERO', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
    const decenas = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
    const decenas2 = ['VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];

    if (centigramos < 10) {
        return 'CERO ' + unidades[centigramos];
    } else if (centigramos < 20) {
        return decenas[centigramos - 10];
    } else {
        const unidad = centigramos % 10;
        const decena = Math.floor(centigramos / 10);
        if (unidad === 0) {
            return decenas2[decena - 2];
        } else {
            return decenas2[decena - 2] + ' Y ' + unidades[unidad];
        }
    }
}

//Añadir un nuevo campo
function mostrarCampoOtros() {
    var selectTipoMuestra = document.getElementById("tipo_muestra");
    var campoOtros = document.getElementById("campo_otros");
    var otroTipoMuestraInput = document.getElementById("otro_tipo_muestra");

    if (selectTipoMuestra.value === "otros") {
        campoOtros.style.display = "block";
        tipoMuestraSelect.value = otroTipoMuestraInput.value;
    } else {
        campoOtros.style.display = "none";
    }
}

// Cambiar resultado
function mostrarOtrosCampos() {
    var tipoMuestra = document.getElementById("tipo_muestra").value;
    var resultadoCualitativoSelect = document.getElementById("resultado_cualitativo");

    if (tipoMuestra === "SIN MUESTRA") {
        // Si se selecciona "SIN MUESTRA", cambiar las opciones del segundo select a "constatación" o "negación"
        resultadoCualitativoSelect.innerHTML = `
            <option value="">--SELECCIONAR--</option>
            <option value="CONSTATACIÓN">CONSTATACIÓN</option>
            <option value="NEGACIÓN">NEGACIÓN</option>
        `;
    } else {
        // Si se selecciona otra opción, restaurar las opciones originales del segundo select
        resultadoCualitativoSelect.innerHTML = `
            <option value="">--SELECCIONAR--</option>
            <option value="positivo">POSITIVO</option>
            <option value="negativo">NEGATIVO</option>
        `;
    }
    mostrarCampoOtros()
}

function mostrarColegiatura() {
    var selectTipoMuestra = document.getElementById("grado");
    var campoOtros = document.getElementById("procesador");
    var otroTipoMuestraInput = document.getElementById("colegiatura");

    if (selectTipoMuestra.value === "MAYOR-S.PNP") {
        campoOtros.style.display = "block";
        tipoMuestraSelect.value = otroTipoMuestraInput.value;
    } else {
        campoOtros.style.display = "none";
    }
}

function mostrarIncurso(){
    let incurso=document.getElementById("resultado_cualitativo");
    let modificar = document.getElementById("modificar");
    if(incurso.value === 'NEGACIÓN'){
        modificar.style.display = 'block'; 
    }else{
        modificar.style.display = 'none';  
    }
}

function togglePasswordVisibility1() {
    const passwordInput = document.getElementById("currentPassword");
    const showPasswordIcon = document.getElementById("show-password1");
    if (passwordInput.getAttribute("type") === "password") {
        passwordInput.setAttribute("type", "text");
        showPasswordIcon.classList.remove("fa-eye-slash");
        showPasswordIcon.classList.add("fa-eye");
    } else {
        passwordInput.setAttribute("type", "password");
        showPasswordIcon.classList.remove("fa-eye");
        showPasswordIcon.classList.add("fa-eye-slash");
    }
}

function togglePasswordVisibility2() {
    const newPasswordInput = document.getElementById("newPassword");
    const showPasswordIcon = document.getElementById("show-password2");
    if (newPasswordInput.getAttribute("type") === "password") {
        newPasswordInput.setAttribute("type", "text");
        showPasswordIcon.classList.remove("fa-eye-slash");
        showPasswordIcon.classList.add("fa-eye");
    } else {
        newPasswordInput.setAttribute("type", "password");
        showPasswordIcon.classList.remove("fa-eye");
        showPasswordIcon.classList.add("fa-eye-slash");
    }
}

function togglePasswordVisibility3() {
    const confirmedPasswordInput = document.getElementById("confirmedPassword");
    const showPasswordIcon = document.getElementById("show-password3");        
    if (confirmedPasswordInput.getAttribute("type") === "password") {
        confirmedPasswordInput.setAttribute("type", "text");
        showPasswordIcon.classList.remove("fa-eye-slash");
        showPasswordIcon.classList.add("fa-eye");
    } else {
        confirmedPasswordInput.setAttribute("type", "password");
        showPasswordIcon.classList.remove("fa-eye");
        showPasswordIcon.classList.add("fa-eye-slash");
    }
}