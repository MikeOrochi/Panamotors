<div class="row" id='form_provider'>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
    <label for="name" class="form-label">* Nombre:</label>
    <input type="text" class="form-control form-control-sm" id="name" name="name" onkeyup="nameAndLastname()" required>
    <div class="invalid-feedback" id='name_feed'>Nombre requerido</div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
    <label for="lastname" class="form-label">* Apellidos:</label>
    <input type="text" class="form-control form-control-sm" name='lastname' id="lastname" onkeyup="nameAndLastname()" required>
    <div class="invalid-feedback" id='latname_feed'>Apellidos requeridos</div>
  </div>
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding:10px" align='center'>
    <div class="alert alert-warning" role="alert" id='alert_name' style="display:none">
      <small id='warnn'></small>
    </div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
    <label for="rfc" class="form-label">RFC:</label>
    <input type="text" class="form-control form-control-sm" name="rfc" id="rfc" onkeyup="rfcCheck()">
    <div class="invalid-feedback" id='rfc_feed'>RFC ya ocupado</div>
    <div align='center'><small id='rfc_exist' style="display:none; color:#FF0000;"></small></div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
    <label for="alias" class="form-label">Alias:</label>
    <input type="text" class="form-control form-control-sm" name="alias" id="alias" onkeyup="aliasCheck()">
    <div class="invalid-feedback" id='alias_feed'>Alias requerido</div>
    <div align='center'><small id='alias_exist' style="display:none; color:#FF0000;"></small></div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
    <label for="phone" class="form-label">* Teléfono:</label>
    <input type="text" class="form-control form-control-sm" name="phone" id="phone" onkeyup="phoneCheck()" required minlength="10" maxlength="10">
    <div class="invalid-feedback" id='phone_feed'>Teléfono requerido</div>
    <div align='center'><small id='phone_exist' style="display:none; color:#FF0000;"></small></div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
    <label for="secondary_phone" class="form-label">Telefóno secundario:</label>
    <input type="text" class="form-control form-control-sm" name="other_phone" id="other_phone" onkeyup="otherPhoneCheck()" minlength="10" maxlength="10">
    <div class="invalid-feedback" id='secondary_phone_feed'>Teléfono ya ocupado</div>
    <div align='center'><small id='other_phone_exist' style="display:none; color:#FF0000;"></small></div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
    <label for="email" class="form-label">* Email:</label>
    <input type="email" class="form-control form-control-sm" name="email" id="email" onkeyup="emailCheck()" required>
    <div class="invalid-feedback" id='email_feed'>Email requerido</div>
    <div align='center'><small id='email_exist' style="display:none; color:#FF0000;"></small></div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
    <label for="type_person">* Identificación</label>
    <select class="form-control" id="type_person" name="type_person" onchange="checkPerson()" required>
      <option disabled>Selecciona una opción</option>
      <option value="fisica" onclick="verifySexShow()" >Persona Física</option>
      <option value="moral" onclick="verifySexNoShow()">Persona Moral</option>
    </select>
  </div>
  <div id='sex_val' class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
    <label for="type_person">* Sexo</label>
    <select class="form-control" id="sex" name="sex">
      <option value="" disabled>Selecciona una opción...</option>
      <option value="Hombre">Hombre</option>
      <option value="Mujer">Mujer</option>
      <option value="Otro">Prefiero no especificar</option>
    </select>
  </div>
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding:10px">
    <label for="social_phisic_reason" class="form-label">Razón Social/Persona Física:</label>
    <input type="social_phisic_reason" class="form-control form-control-sm" name="social_phisic_reason" id="social_phisic_reason">
  </div>
</div>
