<style media="screen">
.redondo{
  border:0px;
  border-radius: 50%;
  background-color: #453F3E;
}
.redondo:hover {
  border:0px;
  color: rgba(255, 255, 255, 1) !important;
  background-color: #000000;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 1);
  transition: all 0.2s ease;
  transform: rotate(-360deg);
  -webkit-transform: rotate(-360deg); // IE 9
  -moz-transform: rotate(-360deg); // Firefox
  -o-transform: rotate(-360deg); // Safari and Chrome
  -ms-transform: rotate(-360deg); // Opera
}
</style>
<div class="col-sm-12">
  <div class="shadow panel-head-primary">
    <h6 class="text-center mt-3 mb-3"><strong>Personal asignado</strong></h6>
    <div class="table-responsive">
      <div class="container">
        <div class="" style="padding:30px">
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <h6 class="text-center mt-3 mb-3"><strong>* No. 1</strong></h6>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
              <label for="first_personal_name" class="form-label">* Nombre:</label>
              <input type="text" class="form-control form-control-sm" id="first_personal_name" name="first_personal_name" required>
              <div class="invalid-feedback" id='first_personal_feed'>Nombre requerido</div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12" style="padding:10px">
              <label for="first_personal_mobile" class="form-label">* Teléfono:</label>
              <input type="phone" class="form-control form-control-sm" name="first_personal_mobile" id="first_personal_mobile" minlength="10" maxlength="10" required>
              <div class="invalid-feedback" id='first_mobile_feed'>Teléfono requerido</div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12" style="padding:10px">
              <label for="first_personal_phone" class="form-label">Teléfono secundario:</label>
              <input type="phone" class="form-control form-control-sm" name="first_personal_phone" id="first_personal_phone" minlength="10" maxlength="10">
            </div>
          </div>
          <div class="row" id='asigned_personal_2' style="display: none;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <h6 class="text-center mt-3 mb-3"><strong>No. 2</strong></h6>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
              <label for="second_personal_name" class="form-label"> Nombre:</label>
              <input type="text" class="form-control form-control-sm" id="second_personal_name" name="second_personal_name">
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12" style="padding:10px">
              <label for="second_personal_mobile" class="form-label"> Teléfono:</label>
              <input type="phone" class="form-control form-control-sm" name="second_personal_mobile" id="second_personal_mobile" minlength="10" maxlength="10">
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12" style="padding:10px">
              <label for="second_personal_phone" class="form-label">Teléfono secundario:</label>
              <input type="phone" class="form-control form-control-sm" name="second_personal_phone" id="second_personal_phone" minlength="10" maxlength="10">
            </div>
          </div>
          <div class="row" id='asigned_personal_3' style="display: none;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <h6 class="text-center mt-3 mb-3"><strong>No. 3</strong></h6>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
              <label for="third_personal_name" class="form-label"> Nombre:</label>
              <input type="text" class="form-control form-control-sm" id="third_personal_name" name="third_personal_name">
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12" style="padding:10px">
              <label for="third_personal_mobile" class="form-label"> Teléfono:</label>
              <input type="phone" class="form-control form-control-sm" name="third_personal_mobile" id="third_personal_mobile" minlength="10" maxlength="10">
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12" style="padding:10px">
              <label for="third_personal_phone" class="form-label">Teléfono secundario:</label>
              <input type="phone" class="form-control form-control-sm" name="third_personal_phone" id="third_personal_phone" minlength="10" maxlength="10">
            </div>
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding:10px" align='right'>
            <button type="button" id='add_asigned_personal' name="add_asigned_personal" class="btn btn-dark redondo" onclick="addAsignedPersonal();" data-toggle="tooltip" data-placement="top" title="Agregar mas personal asignado"><i class="fa fa-plus" aria-hidden="true"></i></button>
            <button type="button" id='remove_asigned_personal' name="remove_asigned_personal" class="btn btn-dark redondo" onclick="removeAsignedPersonal()" style="display:none;" data-toggle="tooltip" data-placement="top" title="Eliminar último personal asignado" disabled><i class="fa fa-minus" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
