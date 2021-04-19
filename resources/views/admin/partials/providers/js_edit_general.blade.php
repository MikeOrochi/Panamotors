<script type="text/javascript">
// console.log('ok 1');
window.validate_name = 0;
window.onload = function(){
  console.log('ok 2');
  $('input').keyup(function(){
    console.log('aaaaaaaaaaaaaaaaa');
  });
}
function verifySexShow() {
  var x = document.getElementById("sex_val");

  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "block";
  }
}
function verifySexNoShow() {
  var x = document.getElementById("sex_val");
  console.log('xd');
  if (x.style.display === "none") {
    x.style.display = "none";
  } else {
    x.style.display = "none";
  }
}
function showSearch(){

  $('#showHideSearch').fadeIn();
  $('#form_provider').fadeOut();
  /*
  var showHideSearch = document.getElementById("");
  var form_provider = document.getElementById("");
  showHideSearch.style.display = "block";
  form_provider.style.display = "none";*/
}
function hideSearch(){
  $('#showHideSearch').fadeOut();
  $('#form_provider').fadeIn();
  // var showHideSearch = document.getElementById("showHideSearch");
  // var showHideSearch = document.getElementById("showHideSearch");
  // showHideSearch.style.display = "none";
  // form_provider.style.display = "block";
}
validate_search = 0;
function searchClientProvider(search_provider_client){
  // if (validate_search==0) {
  validate_search = 1;
  // console.log(search_provider_client);
  fetch('{{route('provider.search','')}}/'+search_provider_client)
  .then(response => response.json())
  .catch(function(error){
    console.error('Error: ',error);
    validate_search = 0;
  })
  .then(function(data){
    validate_search = 0;
    if (data) {
      console.log(data);
      contacts = data.contacts;
      providers = data.providers;
      // console.log(providers[0].idproveedores);
      $('#search_provider_client').empty();
      for(var i in contacts){
        document.getElementById("search_provider_client").innerHTML += "<option value=C"+contacts[i].idcontacto+">"+contacts[i].nombre+" "+contacts[i].apellidos+"</option>";
      }
      for(var i in providers){
        document.getElementById("search_provider_client").innerHTML += "<option value=P"+providers[i].idproveedores+">"+providers[i].nombre+" "+providers[i].apellidos+"</option>";
      }
    }else {
      console.log('no_ok');
    }
  });

  // }
}
function getClientProvider(id){
  // console.log(id);
  // console.log(id);
  route = '{{route('provider.search.byid','')}}/'+id;
  // console.log(route);
  fetch(route)
  .then(response => response.json())
  .catch(function(error){
    console.error('Error: ',error);
    // val_name_lastname = 1;
  })
  .then(function(data){
    if (data) {
      // val_name_lastname = 1;
      $('#name').removeAttr("required");
      $('#lastname').removeAttr("required");
      $('#alias').removeAttr("required");
      $('#phone').removeAttr("required");

      console.log(data);
      if (data.type === 'provider') {
        document.getElementById("id_person").value = data.info.idproveedores;
        document.getElementById("type_person_input").value = data.type;
        document.getElementById('card_name').innerHTML = 'Nombre: '+data.info.nombre+' '+data.info.apellidos;
        document.getElementById('card_rfc').innerHTML = 'RFC: '+data.info.rfc;
        document.getElementById('card_alias').innerHTML = 'Alias: '+data.info.alias;
        document.getElementById('card_phone').innerHTML = 'Teléfono: '+data.info.telefono_celular;
        document.getElementById('card_other_phone').innerHTML = 'Telefono secundario: '+data.info.telefono_otro;
        document.getElementById('card_email').innerHTML = 'Email: '+data.info.email;
        document.getElementById('card_identification').innerHTML = 'Identificación: ';
        document.getElementById('card_sex').innerHTML = 'Sexo: '+data.info.sexo;
      }else if (data.type === 'contact') {
        document.getElementById("id_person").value = data.info.idcontacto;
        document.getElementById("type_person_input").value = data.type;
        document.getElementById('card_name').innerHTML = 'Nombre: '+data.info.nombre+' '+data.info.apellidos;
        document.getElementById('card_rfc').innerHTML = 'RFC: '+data.info.rfc;
        document.getElementById('card_alias').innerHTML = 'Alias: '+data.info.alias;
        document.getElementById('card_phone').innerHTML = 'Teléfono: '+data.info.telefono_celular;
        document.getElementById('card_other_phone').innerHTML = 'Telefono secundario: '+data.info.telefono_otro;
        document.getElementById('card_email').innerHTML = 'Email: '+data.info.email;
        document.getElementById('card_identification').innerHTML = 'Identificación: ';
        document.getElementById('card_sex').innerHTML = 'Sexo: '+data.info.sexo;

      }


      // if (data.email==0) {
      //   $('#email_exist').fadeOut();
      // }else {
      //   document.getElementById('email_exist').innerHTML = 'Existen '+data.email+' Email iguales';
      //   $('#email_exist').fadeIn();
      // }
      // val_name_lastname = 0;
    }else {
      console.log('no_ok');
      // val_name_lastname = 0;
    }
  });
}
function getZip(){
  zip_code = document.getElementsByName("zip")[0].value;
  console.log(zip_code.length);
  if (zip_code.length < 5) {
    div_state.style.display = "none";
    div_township.style.display = "none";
    div_colony.style.display = "none";
    div_other_colony.style.display = "none";
    div_street.style.display = "none";
  }else if (zip_code.length > 5){
    div_state.style.display = "none";
    div_township.style.display = "none";
    div_colony.style.display = "none";
    div_other_colony.style.display = "none";
    div_street.style.display = "none";
    error_zip.style.display = "block";
  }else {
    console.log(zip_code);
    fetch('{{route('zip.show','')}}/'+zip_code)
    .then(response => response.json())
    .catch(error =>console.error('Error: ',error))
    .then(function(data){
      if (data) {
        console.log(data);
        colonies = data.colony;
        console.log(colonies);
        document.getElementById("state").value = data.state;
        document.getElementById("state_hid").value = data.state;
        document.getElementById("township").value = data.township;
        document.getElementById("township_hid").value = data.township;
        $('#colony').empty();
        for(var i in colonies){
          document.getElementById("colony").innerHTML += "<option value='"+colonies[i]+"'>"+colonies[i]+"</option>";
        }


        // var state_hid = document.getElementById("state_hid");
        // var township_hid = document.getElementById("township_hid");
        var div_state = document.getElementById("div_state");
        var div_township = document.getElementById("div_township");
        var div_colony = document.getElementById("div_colony");
        var div_other_colony = document.getElementById("div_other_colony");
        var div_street = document.getElementById("div_street");
        var error_zip = document.getElementById("error_zip");
        div_state.style.display = "block";
        div_township.style.display = "block";
        div_colony.style.display = "block";
        div_other_colony.style.display = "block";
        div_street.style.display = "block";
        error_zip.style.display = "none";
      }else {
        console.log('no_ok');
        var error_zip = document.getElementById("error_zip");
        var div_state = document.getElementById("div_state");
        var township = document.getElementById("div_township");
        var div_colony = document.getElementById("div_colony");
        var div_other_colony = document.getElementById("div_other_colony");
        var div_street = document.getElementById("div_street");
        var error_zip = document.getElementById("error_zip");
        div_state.style.display = "none";
        township.style.display = "none";
        div_colony.style.display = "none";
        div_other_colony.style.display = "none";
        div_street.style.display = "none";
        error_zip.style.display = "block";
      }
    });
  }
}
function verifyZip(){
  zip_code = document.getElementsByName("zip")[0].value;
  console.log(zip_code);
  fetch('{{route('zip.show','')}}/'+zip_code)
  .then(response => response.json())
  .catch(error =>console.error('Error: ',error))
  .then(function(data){
    if (data) {
      console.log(data);
      colonies = data.colony;
      console.log(colonies);
      document.getElementById("state").value = data.state;
      document.getElementById("state_hid").value = data.state;
      document.getElementById("township").value = data.township;
      document.getElementById("township_hid").value = data.township;
      $('#colony').empty();
      for(var i in colonies){
        document.getElementById("colony").innerHTML += "<option value='"+colonies[i]+"'>"+colonies[i]+"</option>";
      }


      // var state_hid = document.getElementById("state_hid");
      // var township_hid = document.getElementById("township_hid");
      var div_state = document.getElementById("div_state");
      var township = document.getElementById("div_township");
      var div_colony = document.getElementById("div_colony");
      var div_other_colony = document.getElementById("div_other_colony");
      var div_street = document.getElementById("div_street");
      var error_zip = document.getElementById("error_zip");
      div_state.style.display = "block";
      township.style.display = "block";
      div_colony.style.display = "block";
      div_other_colony.style.display = "block";
      div_street.style.display = "block";
      error_zip.style.display = "none";
    }else {
      console.log('no_ok');
      var error_zip = document.getElementById("error_zip");
      var div_state = document.getElementById("div_state");
      var township = document.getElementById("div_township");
      var div_colony = document.getElementById("div_colony");
      var div_other_colony = document.getElementById("div_other_colony");
      var div_street = document.getElementById("div_street");
      var error_zip = document.getElementById("error_zip");
      div_state.style.display = "none";
      township.style.display = "none";
      div_colony.style.display = "none";
      div_other_colony.style.display = "none";
      div_street.style.display = "none";
      error_zip.style.display = "block";

    }
  });
}
function validarCheck(){
  if(document.getElementById("product").checked!=1 && document.getElementById("service").checked!=1 && document.getElementById("others").checked!=1){
    // alert("Es necesario elegir al menos un tipo de proveedor");
    swal("¡Atención!", "Debes selecionar al menos un producto", "error");
    document.getElementById("product").checked=1;
  }
}


function rfcCheck(){
  rfc = document.getElementsByName("rfc")[0].value;
  console.log(rfc);
  route = '{{route('provider.search.rfc','')}}/'+rfc;
  // console.log(route);
  fetch(route)
  .then(response => response.json())
  .catch(function(error){
    console.error('Error: ',error);
    // val_name_lastname = 1;
  })
  .then(function(data){
    if (data) {
      // val_name_lastname = 1;
      console.log(data.rfc);
      if (data.rfc==0) {
        // $('#rfc_exist').fadeOut();
        document.getElementById('rfc').setCustomValidity("");
        $('#rfc_feed').fadeOut();
      }else {
        document.getElementById('rfc_feed').innerHTML = 'Existen '+data.rfc+' RFCs iguales';
        $('#rfc_feed').fadeIn();
        document.getElementById('rfc').setCustomValidity("RFC repetido");
        // $('#rfc_exist').fadeIn();
      }
      // val_name_lastname = 0;
    }else {
      console.log('no_ok');
      // val_name_lastname = 0;
    }
  });
}
function aliasCheck(){
  alias = document.getElementsByName("alias")[0].value;
  console.log(alias);
  route = '{{route('provider.search.alias','')}}/'+alias;
  // console.log(route);
  fetch(route)
  .then(response => response.json())
  .catch(function(error){
    console.error('Error: ',error);
    // val_name_lastname = 1;
  })
  .then(function(data){
    if (data) {
      // val_name_lastname = 1;
      console.log(data.alias);
      if (data.alias==0) {
        document.getElementById('alias').setCustomValidity("");
        $('#alias_feed').fadeOut();
      }else {
        document.getElementById('alias').setCustomValidity("Alias repetido");
        document.getElementById('alias_feed').innerHTML = 'Existen '+data.alias+' Alias iguales';
        $('#alias_feed').fadeIn();
      }
      // val_name_lastname = 0;
    }else {
      console.log('no_ok');
      // val_name_lastname = 0;
    }
  });
}
function phoneCheck(){
  phone = document.getElementsByName("phone")[0].value;
  console.log(phone);
  route = '{{route('provider.search.phone','')}}/'+phone;
  // console.log(route);
  fetch(route)
  .then(response => response.json())
  .catch(function(error){
    console.error('Error: ',error);
    // val_name_lastname = 1;
  })
  .then(function(data){
    if (data) {
      // val_name_lastname = 1;
      console.log(data.phone);
      if (data.phone==0) {
        $('#phone_feed').fadeOut();
        document.getElementById('phone').setCustomValidity("");
      }else {
        document.getElementById('phone_feed').innerHTML = 'Existen '+data.phone+' Teléfonos iguales';
        $('#phone_feed').fadeIn();
        document.getElementById('phone').setCustomValidity("Teléfono repetido");
      }
      // val_name_lastname = 0;
    }else {
      console.log('no_ok');
      // val_name_lastname = 0;
    }
  });

}
function otherPhoneCheck(){
  other_phone = document.getElementsByName("other_phone")[0].value;
  console.log(other_phone);
  route = '{{route('provider.search.phone','')}}/'+other_phone;
  console.log(route);
  fetch(route)
  .then(response => response.json())
  .catch(function(error){
    console.error('Error: ',error);
    // val_name_lastname = 1;
  })
  .then(function(data){
    if (data) {
      // val_name_lastname = 1;
      console.log(data.phone);
      if (data.phone==0) {
        $('#secondary_phone_feed').fadeOut();
        document.getElementById('other_phone').setCustomValidity("");
      }else {
        document.getElementById('secondary_phone_feed').innerHTML = 'Existen '+data.phone+' Teléfonos iguales';
        $('#secondary_phone_feed').fadeIn();
        document.getElementById('other_phone').setCustomValidity("Teléfono repetido");

      }
      // val_name_lastname = 0;
    }else {
      console.log('no_ok');
      // val_name_lastname = 0;
    }
  });
}
function validarEmail(valor) {
  emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    //Se muestra un texto a modo de ejemplo, luego va a ser un icono
    if (emailRegex.test(valor)) {
      return"ok";
    } else {
      return "no_ok";
    }
}
function emailCheck(){

  email = document.getElementsByName("email")[0].value;
  console.log(email);
  console.log(validarEmail(email));
  if (validarEmail(email)=='no_ok') {
    document.getElementById('email_feed').innerHTML = 'Email no valido, revisa la estructura';
    $('#email_feed').fadeIn();
    document.getElementById('email').setCustomValidity("Email no valido, revisa la estructura");
  }else {
    console.log(email);
    route = '{{route('provider.search.email','')}}/'+email;
    console.log(route);
    fetch(route)
    .then(response => response.json())
    .catch(function(error){
      console.error('Error: ',error);
      // val_name_lastname = 1;
    })
    .then(function(data){
      if (data) {
        // val_name_lastname = 1;
        console.log(data.email);
        if (data.email==0) {
          $('#email_feed').fadeOut();
          document.getElementById('email').setCustomValidity("");
        }else {
          document.getElementById('email_feed').innerHTML = 'Existen '+data.email+' Email iguales';
          $('#email_feed').fadeIn();
          document.getElementById('email').setCustomValidity("Email repetido");
        }
        // val_name_lastname = 0;
      }else {
        console.log('no_ok');
        // val_name_lastname = 0;
      }
    });
  }

}
function checkPerson(){
  var w =document.getElementsByName("type_person")[0].value;
  if (w != 'moral') {
    var x = document.getElementById("sex_val");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "block";
    }
  }else {
    var x = document.getElementById("sex_val");
    console.log('xd');
    if (x.style.display === "none") {
      x.style.display = "none";
    } else {
      x.style.display = "none";
    }
  }
}
document.addEventListener("DOMContentLoaded", function(event) {
  document.getElementById('mi_formulario').addEventListener('submit',
  manejadorValidacion)
});

function manejadorValidacion(e) {
  e.preventDefault();

  /*var institucion_receptora = document.getElementById("institution_receptor").value;
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

}*/
/*if(! validateEmail(this.querySelector('[name=email]').value))
{ console.log('El email no es válido');
msg.innerText = 'Debes escribir un email
válido'; return;
}*/
var rfc_exist = $("#rfc_feed").is(":visible");
var alias_exist = $("#alias_feed").is(":visible");
var phone_exist = $("#phone_feed").is(":visible");
var other_phone_exist = $("#secondary_phone_feed").is(":visible");
var email_exist = $("#email_feed").is(":visible");
var div_state = $("#div_state").is(":visible");
console.log(div_state);
var errors = false;
if (rfc_exist==true) {
errors = true;
}
if (alias_exist==true) {
errors = true;
}
if (phone_exist==true) {
errors = true;
}
if (other_phone_exist==true) {
errors = true;
}
if (email_exist==true) {
errors = true;
}
if (div_state!=true) {
errors = true;
}
console.log(errors);
if (errors==true) {
swal("¡Atención!", 'Revisa que los datos ingresados sean correctos', "error");
return;
}
console.log(errors);
var esVisible = $("#alert_name").is(":visible");
let msg = '';
if (esVisible==true) {
msg = "Existen clientes con nombre similar ¿Deseas Continuar?";
}else {
msg = "¿Desea guardar los cambios?";
}
console.log(msg);
swal({
title: msg,
text: "",
icon: "warning",
buttons: ["No", "Si"],
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
window.addEventListener("load", function() {
// getZip();
mi_formulario.phone.addEventListener("keypress", soloNumeros, false);
mi_formulario.other_phone.addEventListener("keypress", soloNumeros, false);
mi_formulario.zip.addEventListener("keypress", soloNumeros, false);
mi_formulario.first_personal_mobile.addEventListener("keypress", soloNumeros, false);
mi_formulario.first_personal_phone.addEventListener("keypress", soloNumeros, false);
mi_formulario.second_personal_mobile.addEventListener("keypress", soloNumeros, false);
mi_formulario.second_personal_phone.addEventListener("keypress", soloNumeros, false);
mi_formulario.third_personal_mobile.addEventListener("keypress", soloNumeros, false);
mi_formulario.third_personal_phone.addEventListener("keypress", soloNumeros, false);

});

//Solo permite introducir numeros.
function soloNumeros(e){
var key = window.event ? e.which : e.keyCode;
if (key < 48 || key > 57) {
  e.preventDefault();
}
}
function addAsignedPersonal(){
  var asigned_personal_2 = $("#asigned_personal_2").is(":visible");
  var asigned_personal_3 = $("#asigned_personal_3").is(":visible");
  if (asigned_personal_2===false && asigned_personal_3===false) {
    $('#remove_asigned_personal').removeAttr("disabled");
    $('#asigned_personal_2').removeClass('fadeOutLeft_izi');
    $('#asigned_personal_2').addClass('flipInRight_izi');
    $('#asigned_personal_2').fadeIn();
    $('#remove_asigned_personal').removeClass('fadeOutDown_izi');
    $('#remove_asigned_personal').addClass('bounceInUp_izi');
    $('#remove_asigned_personal').fadeIn();

  }else if (asigned_personal_2===true && asigned_personal_3===false) {
    $('#add_asigned_personal').attr('disabled','disabled');
    $('#asigned_personal_3').removeClass('fadeOutLeft_izi');
    $('#asigned_personal_3').addClass('flipInRight_izi');
    $('#add_asigned_personal').removeClass('bounceInUp_izi');
    $('#add_asigned_personal').addClass('fadeOutDown_izi');
    $('#add_asigned_personal').fadeOut();
    $('#asigned_personal_3').fadeIn('slow');
  }
}
function removeAsignedPersonal(){
  var asigned_personal_2 = $("#asigned_personal_2").is(":visible");
  var asigned_personal_3 = $("#asigned_personal_3").is(":visible");
  if (asigned_personal_2===true && asigned_personal_3===false) {
    $('#remove_asigned_personal').attr('disabled','disabled');
    $('#remove_asigned_personal').fadeOut();
    $('#asigned_personal_2').removeClass('flipInRight_izi');
    $('#asigned_personal_2').addClass('fadeOutLeft_izi');
    $('#remove_asigned_personal').attr('disabled','disabled');
    $('#remove_asigned_personal').removeClass('bounceInUp_izi');
    $('#remove_asigned_personal').addClass('fadeOutDown_izi');
    $('#remove_asigned_personal').fadeOut();
    $('#asigned_personal_2').fadeOut();
    $('#add_asigned_personal').removeClass('fadeOutDown_izi');
    $('#add_asigned_personal').addClass('bounceInUp_izi');
    $('#add_asigned_personal').fadeIn();
    document.getElementById("second_personal_name").value = '';
    document.getElementById("second_personal_mobile").value = '';
    document.getElementById("second_personal_phone").value = '';
  }else if (asigned_personal_2===true && asigned_personal_3===true) {
    $('#asigned_personal_3').removeClass('flipInRight_izi');
    $('#asigned_personal_3').addClass('fadeOutLeft_izi');
    $('#asigned_personal_3').fadeOut();
    $('#add_asigned_personal').removeAttr("disabled");
    $('#add_asigned_personal').removeClass('fadeOutDown_izi');
    $('#add_asigned_personal').addClass('bounceInUp_izi');
    $('#add_asigned_personal').fadeIn();
    document.getElementById("third_personal_name").value = '';
    document.getElementById("third_personal_mobile").value = '';
    document.getElementById("third_personal_phone").value = '';

  }
}
</script>
