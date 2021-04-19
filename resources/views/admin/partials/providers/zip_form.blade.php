<div class="col-sm-12">
  <div class="shadow panel-head-primary">
    <h6 class="text-center mt-3 mb-3"><strong>Dirección</strong></h6>
    <div class="table-responsive">
      <div class="container">
        <div class="row" style="padding:30px">
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <label for="zip" class="form-label">* Codigo postal:</label>
            <input type="text" class="form-control form-control-sm" id="zip" name="zip" onkeyup="getZip()" minlength="5" maxlength="5" required>
            <div class="invalid-feedback" id='zip_feed'>Código postal requerido</div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:30px">
            {{-- <button type="button" name="verify_zip" class="btn btn-dark" onclick="verifyZip()">Verificar</button> --}}
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div id='div_state' style="display:none" class='flipInRight_izi'>
              <label for="state" class="form-label">* Estado:</label>
              <input type="hidden" class="form-control form-control-sm" name="state_hid" id="state_hid" required>
              <input type="text" class="form-control form-control-sm" id="state" disabled>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div id="div_township" style="display:none" class='flipInRight_izi'>
              <label for="township" class="form-label">Municipio:</label>
              <input type="hidden" class="form-control form-control-sm" name="township_hid" id="township_hid" required>
              <input type="text" class="form-control form-control-sm" id="township" disabled>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div id="div_colony" style="display:none" class='flipInRight_izi'>
              <label for="colony">Colonia:</label>
              <select class="form-control form-control-sm" id="colony" name="colony">
                <option value="" disabled>Selecciona una opción...</option>
              </select>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div id="div_other_colony" style="display:none" class='flipInRight_izi'>
              <label for="other_colony" class="form-label">¿No aparece tu colonia? Coloca su nombre abajo:</label>
              <input type="text" class="form-control form-control-sm" name="other_colony" id="other_colony">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div id="div_street" style="display:none" class='flipInRight_izi'>
              <label for="street" class="form-label">Calle y número:</label>
              <input type="text" class="form-control form-control-sm" name="street" id="street">
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="alert alert-danger  flipInRight_izi" role="alert" id='error_zip' style="margin-top:-50px; display: none" align='center'>
              Error, código postal no encontrado
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
