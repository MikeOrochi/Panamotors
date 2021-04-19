<div class="col-sm-12">
  <div class="shadow panel-head-primary">
    <h6 class="text-center mt-3 mb-3"><strong>Tipo de provedor</strong></h6>
    <div class="table-responsive">
      <div class="container">
        <div class="row" style="padding:30px">
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="margin-left: 40%; padding:10px;">
              <label class="form-label">*Tipo:</label>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="margin-left: 35%">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="product" name="product" value="1" onclick="validarCheck()" @if($provider->col8!='') checked @endif>
                <label class="form-check-label" for="product">Producto</label>
              </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="margin-left: 35%">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="service" value="1" name="service" onclick="validarCheck()" @if($provider->col7!='') checked @endif>
                <label class="form-check-label" for="service">Servicio</label>
              </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="margin-left: 35%">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="others" value="1" name="others" onclick="validarCheck()" @if($provider->col6!='') checked @endif>
                <label class="form-check-label" for="others">Otro</label>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="padding:10px">
            <label for="type_person">* Segmentación</label>
            <select class="form-control" name="segmentation" id="type_person" required>
              <option value="" disabled>Selecciona una opción...</option>
              @foreach ($segmentations as $segmentation)
                <option value="{{$segmentation->idsegmentacion}}">{{$segmentation->nombre}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding:10px" align='center'>
            <button type="submit" name="button" class="btn btn-dark">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
