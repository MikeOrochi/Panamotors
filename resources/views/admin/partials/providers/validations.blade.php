<script type="text/javascript">
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
        if (data.phone!='') {
          document.getElementById('phone_feed').innerHTML = 'Existen '+data.phone+' Teléfonos iguales';
        }else {
          document.getElementById('phone_feed').innerHTML = 'Teléfono requerido';
        }
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
    $('#social_phisic_reason').attr('required',false);
    var x = document.getElementById("sex_val");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "block";
    }
  }else {
    $('#social_phisic_reason').attr("required",true);
    var x = document.getElementById("sex_val");
    console.log('xd');
    if (x.style.display === "none") {
      x.style.display = "none";
    } else {
      x.style.display = "none";
    }
  }
}
</script>
