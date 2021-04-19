<div class="col-sm-6 form-group">
    <label for="">Motor</label>
    <input type="text" name="motor" class="form-control motor" id="motor" list="motores" value="{{$inventario_dinamico_truck->motor}}" required>
    <datalist id="motores">
        @foreach ($options_trucks->motor as $value) {
            <option value='{{$value}}'></option>
        @endforeach
    </datalist>
</div>

<div class="col-sm-6 form-group">
    <label for="">Eje Delantero</label>
    <input type="text" name="eje_delantero" class="form-control eje_delantero" id="eje_delantero" list="eje_delanteros" value="{{$inventario_dinamico_truck->eje_delantero}}" required>
    <datalist id="eje_delanteros">
        @foreach($options_trucks->eje_delantero as $value)
            <option value='{{$value}}'></option>
        @endforeach
    </datalist>
</div>

<div class="col-sm-6 form-group">
    <label for="">Eje Trasero</label>
    <input type="text" name="eje_trasero" class="form-control eje_trasero" id="eje_trasero" list="eje_traseros" value="{{$inventario_dinamico_truck->eje_trasero}}" required>
    <datalist id="eje_traseros">
        @foreach($options_trucks->eje_trasero  as $value)
            <option value='{{$value}}'></option>
        @endforeach
    </datalist>
</div>

<div class="col-sm-6 form-group">
    <label for="">Rodado</label>
    <input type="text" name="rodado" class="form-control rodado" id="rodado" list="rodados" value="{{$inventario_dinamico_truck->rodado}}" required>
    <datalist id="rodados">
        @foreach($options_trucks->rodado  as $value)
            <option value='{{$value}}'></option>
        @endforeach
    </datalist>
</div>


<div class="col-sm-6 form-group">
    <label for="">Camarote</label>
    <input type="text" name="camarote" class="form-control camarote" id="camarote" list="camarotes" value="{{$inventario_dinamico_truck->camarote}}" required>
    <datalist id="camarotes">
        @foreach($options_trucks->camarote as $value)
            <option value='{{$value}}'></option>
        @endforeach
    </datalist>
</div>

<div class="col-sm-6 form-group">
    <label for="">Tipo de Tracto</label>
    <input type="text" name="tipo_tracto" class="form-control tipo_tracto" id="tipo_tracto" list="tipo_tractos" value="{{$inventario_dinamico_truck->tipo_tracto}}" required>
    <datalist id="tipo_tractos">
        @foreach($options_trucks->tipo_tracto as  $value)
            <option value='{{$value}}'></option>
        @endforeach
    </datalist>
</div>

<div class="col-sm-6 form-group">
    <label for="">Potencia</label>
    <input type="text" name="potencia" class="form-control potencia" id="potencia" list="potencias" value="{{$inventario_dinamico_truck->potencia}}" required>
    <datalist id="potencias">
        @foreach($options_trucks->potencia as $value)
            <option value='{{$value}}'></option>
        @endforeach
    </datalist>
</div>

<div class="col-sm-12 form-group">
    <label for="">Velocidades</label>
    <input type="text" name="velocidades" class="form-control velocidades" id="velocidades" list="velocidadess" value="{{$inventario_dinamico_truck->velocidades}}" required>
    <datalist id="velocidadess">
        @foreach($options_trucks->velocidades as $value)
            <option value='{{$value}}'></option>
        @endforeach
    </datalist>
</div>

<!-- <div class="col-sm-12">
<div class="form-group">
    <label>Facturable</label>  -->
    <input type="hidden" value="Pendiente" name="facturable">
    <!-- <select name="facturable" class="form-control" id="facturable" required>
        <option value="<?php //echo //$fac; ?>"><?php //echo "--- ".$fac." ---"; ?></option>
        <option value="SI">SI</option>
        <option value="NO">NO</option>
    </select> -->

<!-- </div>
</div> -->
<!-- <div class="col-sm-12 form-group">
<label for="">*IVA</label> -->
<input type="hidden" name="iva" value="Pendiente">
<!-- <select name="iva" id="iva" class="form-control">
    <option value="<?php //echo $iva; ?>"><?php //echo "--- ".$iva." ---"; ?></option>
    <option value="IVA sobre utilidad">IVA sobre utilidad</option>
    <option value="IVA total">IVA total</option>
    <option value="Pendiente">Pendiente</option>
</select>
</div> -->
<!-- <div class="col-sm-12 form-group">
<label for="">Estatus</label> -->
<input type="hidden" name="estatus" value="Pendiente">
<!-- <select name="estatus" id="estatus" class="form-control" required="">
    <option value="<?php //echo $estatus; ?>"><?php //echo "--- ".$estatus." ---"; ?></option>
    <option value="Pendiente">Pendiente</option>
    <option value="Proceso">Proceso</option>
    <option value="Autorizado">Autorizado</option>
    <option value="Rechazado">Rechazado</option>
</select>
</div> -->
