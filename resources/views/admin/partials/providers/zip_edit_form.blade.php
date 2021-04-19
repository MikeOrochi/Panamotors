<div class="col-sm-12">
  <div class="shadow panel-head-primary">
    <h6 class="text-center mt-3 mb-3"><strong>Dirección</strong></h6>
    <div class="table-responsive">
      <div class="container">
        <div class="row" style="padding:30px">
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <label for="zip" class="form-label">* Codigo postal:</label>
            <input type="text" class="form-control form-control-sm" value='{{$provider->codigo_postal}}' id="zip" name="zip" onkeyup="getZip()" minlength="5" maxlength="5" required>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:30px">
            {{-- <button type="button" name="verify_zip" class="btn btn-dark" onclick="verifyZip()">Verificar</button> --}}
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div class="flipInRight_izi" id='div_state' style="display:block">
              <label for="state" class="form-label">* Estado:</label>
              <input type="hidden" class="form-control form-control-sm" name="state_hid" value='{{$provider->estado}}' id="state_hid" required>
              <input type="text" class="form-control form-control-sm" id="state" value='{{$provider->estado}}' disabled>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div class="flipInRight_izi" id="div_township" style="display:block">
              <label for="township" class="form-label">Municipio:</label>
              <input type="hidden" class="form-control form-control-sm" name="township_hid" value='{{$provider->delmuni}}' id="township_hid" required>
              <input type="text" class="form-control form-control-sm" id="township" value='{{$provider->delmuni}}' disabled>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div class="flipInRight_izi" id="div_colony" style="display:block">
              <label for="colony">Colonia:</label>
              <select class="form-control form-control-sm" id="colony" name="colony">
                <option value="" disabled>Selecciona una opción...</option>
                <option value="{{$provider->colonia}}">{{$provider->colonia}}</option>
                @foreach ($direction as $directs)
                  @if ($directs!=$provider->colonia)
                    <option value="{{$directs}}">{{$directs}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div class="flipInRight_izi" id="div_other_colony" style="display:block">
              <label for="other_colony" class="form-label">¿No aparece tu colonia? Coloca su nombre abajo:</label>
              <input type="text" class="form-control form-control-sm" name="other_colony" id="other_colony">
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div class="flipInRight_izi" id="div_street" style="display:block">
              <label for="street" class="form-label">Calle y número:</label>
              <input type="text" class="form-control form-control-sm" name="street" id="street" value='{{$provider->calle}}'>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="alert alert-danger flipInRight_izi" role="alert" id='error_zip' style="margin-top:-50px; display: none" align='center'>
              Error, código postal no encontrado
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
