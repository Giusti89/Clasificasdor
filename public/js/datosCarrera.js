let selectTrans = document.getElementById('transferir');
let transfer = document.getElementById('transferencia');
let trans = document.getElementById('trasnferir');
let agregar= document.getElementById('agregar');
let restar= document.getElementById('reducir');
let txtagregar= document.getElementById('txtagregar');
let txtrestar= document.getElementById('txtreducir');

document.addEventListener('DOMContentLoaded', function () {


    transfer.style.display = 'none';

    const selectCarrera = document.getElementById('carrera_id');
    const inputPresupuesto = document.getElementById('presupuesto');

    selectCarrera.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const presupuesto = selectedOption.getAttribute('data-presupuesto');
        inputPresupuesto.value = presupuesto;
    });

    selectTrans.addEventListener('change', function () {

        if (selectTrans.checked) {
            // Si el checkbox está marcado, mostrar el div
            transfer.style.display = 'block';
            agregar.value='';
            restar.value='';
            agregar.style.display = 'none';
            restar.style.display = 'none';
            txtrestar.style.display = 'none'
            txtagregar.style.display = 'none'
            selectCarrera.selectedIndex = 0; 
            inputPresupuesto.value = '';

        } else {
            // Si el checkbox no está marcado, ocultar el div
            transfer.style.display = 'none';
            trans.value = '';
            agregar.style.display = 'block';
            restar.style.display = 'block';
            txtrestar.style.display = 'block'
            txtagregar.style.display = 'block'
        }
    });
});
