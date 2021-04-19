<script type="text/javascript">
let reference_ok = false;
function searchContact(search_contact){
  // console.log(search_contact);
  fetch('{{route('contact.search','')}}/'+search_contact)
  .then(response => response.json())
  .catch(function(error){
    console.error('Error: ',error);
    // validate_search = 0;
  })
  .then(function(data){
    // validate_search = 0;
    if (data) {
      contacts = data.contacts;
      // console.log(data.contacts);
      $('#search_contact').empty();
      for(var i in contacts){
        document.getElementById("search_contact").innerHTML += "<option value="+contacts[i].idcontacto+">"+contacts[i].nombre+" "+contacts[i].apellidos+"</option>";
      }
    }else {
      console.log('no_ok');
    }
  });
}
function getClient(idcontacto){
  console.log(idcontacto);
  fetch('{{route('contact.show','')}}/'+idcontacto)
  .then(response => response.json())
  .catch(function(error){
    console.error('Error: ',error);
    // validate_search = 0;
  })
  .then(function(data){
    // validate_search = 0;
    if (data) {
      document.getElementById("institution_receptor").value = data.contacts.idcontacto;
      document.getElementById("agent_receptor").value = data.contacts.idcontacto;
      document.getElementById("agent_nomenclatura").value = data.contacts.nomeclatura;
      document.getElementById('institution_receptor_span').innerHTML = ''+data.contacts.idcontacto+'.'+data.contacts.nomeclatura;
      document.getElementById('agent_receptor_span').innerHTML = ''+data.contacts.idcontacto+'.'+data.contacts.nomeclatura;
    }else {
      console.log('no_ok');
    }
  });
}
let cambioUSD = 19.50;
let cambioCAD = 15.20;
let cambioMXN = 1;
function typeChange(){
  var change = document.getElementById("tipo_moneda").value;
  if (change==='MXN') {
    document.getElementById("type_change").value = cambioMXN.toFixed(2);
    document.getElementById("type_change_hid").value = cambioMXN.toFixed(2);
  }else if (change==='USD') {
    document.getElementById("type_change").value = cambioUSD.toFixed(2);
    document.getElementById("type_change_hid").value = cambioUSD.toFixed(2);
  }else if (change==='CAD') {
    document.getElementById("type_change").value = cambioCAD.toFixed(2);
    document.getElementById("type_change_hid").value = cambioCAD.toFixed(2);
  }
  updateNewSaldo();
  getNumberToLetters();
  console.log(x);
}
function updateNewSaldo(){
  var change = document.getElementById("tipo_moneda").value;
  var quantity = document.getElementById("quantity").value;
  if (change==='MXN') {
    let total = {{$saldo}}-(quantity*cambioMXN);
    document.getElementById("new_earnings").value = total.toFixed(2);
  }else if (change==='USD') {
    let total = {{$saldo}}-(quantity*cambioUSD);
    document.getElementById("new_earnings").value = total.toFixed(2);
  }else if (change==='CAD') {
    let total = {{$saldo}}-(quantity*cambioCAD);
    document.getElementById("new_earnings").value = total.toFixed(2);
  }
  getNumberToLetters();
}
function getNumberToLetters(){
  var change = document.getElementById("tipo_moneda").value;
  var quantity = document.getElementById("quantity").value;
  fetch('{{route('number.letters.convert',['',''])}}/'+quantity+'/'+change)
  .then(response => response.json())
  .catch(function(error){
    console.error('Error: ',error);
  })
  .then(function(data){
    if (data) {
      document.getElementById("quantity_letter").value = data.info;
    }else {
      document.getElementById("quantity_letter").value = '- CON -/100 MXN';
    }
  });
}
function validateReference(){
  var institucion_receptora = document.getElementById("institution_receptor").value;
  var agent_nomenclatura = document.getElementById("agent_nomenclatura").value;
  var institucion_emisor_ = document.getElementById("bank_emisor").value;
  institucion_emisor=agent_nomenclatura+'.'+institucion_emisor_;
  var agente_receptor_ = document.getElementById("agent_receptor").value;
  agente_receptor=agent_nomenclatura+'.'+agente_receptor_;
  var n_referencia = document.getElementById("reference").value;
  var monto_general1 = document.getElementById("earnings_hid").value;
  var monto_cantidad = document.getElementById("quantity").value;
  var TipoMovi = document.getElementById("type_movement").value;
  // console.log(TipoMovi);
  var idco = '{{$id}}';
  if (n_referencia.length != 6) {
    document.getElementById('label_reference').innerHTML = 'Número de referencia: <i class="fas fa-times-circle" style="color: red;">';
    reference_ok = false;
  }else {
    fetch("{{route('search.ref')}}", {
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-Token": '{{csrf_token()}}',
      },
      method: "post",
      credentials: "same-origin",
      body: JSON.stringify({
        ins_receptora: institucion_receptora,
        ag_receptor: agente_receptor,
        ref: n_referencia,
        ins_e: institucion_emisor,
        m_g: monto_general1,
        ic: idco,
        cantidad: monto_cantidad,
        tipo_mov : TipoMovi
      })
    }).then(res => res.json())
    .catch(function(error) {
      console.error('Error:', error);
      document.getElementById('label_reference').innerHTML = 'Número de referencia: <i class="fas fa-times-circle" style="color: red;">';
      reference_ok = false;
    })
    .then(function(response) {
      if (response == "SI") {
        document.getElementById('label_reference').innerHTML = 'Número de referencia: <i class="fas fa-check-circle" style="color:green;"></i>';
        console.log(response);
        reference_ok = true;
        $('#reference_feed').fadeOut();


      } else {
        document.getElementById('reference_feed').innerHTML = 'Error: '+response;
        $('#reference_feed').fadeIn();
        console.log(response);
        document.getElementById('label_reference').innerHTML = 'Número de referencia: <i class="fas fa-times-circle" style="color: red;">';
        reference_ok = false;
      }
      if (n_referencia=='') {
        document.getElementById('label_reference').innerHTML = 'Número de referencia: <i class="fas fa-times-circle" style="color: red;">';
        reference_ok = false;
      }
    });
  }
}
document.addEventListener("DOMContentLoaded", function(event) {
  document.getElementById('mi_formulario').addEventListener('submit',
  manejadorValidacion)
});

function manejadorValidacion(e) {
  e.preventDefault();
  var institucion_receptora = document.getElementById("institution_receptor").value;
  var quantity = document.getElementById("quantity").value;
  var errors = '';
  var count = 1;
  if(institucion_receptora == '') {
    errors = errors+count+' - Debes buscar un receptor \n';
    count++;
  }
  if(quantity == '' || quantity < 1 || isNaN(quantity)) {
    errors = errors+count+' - Debes ingresar un monto mayor a 0 \n';
    count++;
  }
  if (reference_ok == false) {
    errors = errors+count+' - La referencia agregada no es valida \n';
    count++;
  }
  if (errors!='') {
    swal("¡Atención!", errors, "error");
    return;

  }
  /*if(! validateEmail(this.querySelector('[name=email]').value))
  { console.log('El email no es válido');
  msg.innerText = 'Debes escribir un email
  válido'; return;
}*/
swal({
  title: "¿Estas seguro de continuar?",
  text: "Una vez presiones OK no se podran deshacer los cambios",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    $('#Myloader').fadeIn();
    this.submit();
  } else {
    swal("Los datos NO se han guardado");
  }
});
}
//
// function validateEmail(email) {
//   var re =
//   /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]
//     {1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//     return re.test(String(email).toLowerCase());
//   }
window.addEventListener("load", function() {
mi_formulario.quantity.addEventListener("keypress", soloNumeros, false);
});

//Solo permite introducir numeros.
function soloNumeros(e){
var key = window.event ? e.which : e.keyCode;
if (key != 46) {
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
}
}
</script>
