@php
  use App\Models\usuarios;
  $user_maker = \Request::cookie('usuario_creador');
  $user = usuarios::where('idusuario', $user_maker)->get(['idusuario','rol'])->first();
@endphp
@if ($user->rol == 17)
  @include('admin.partials.menu')
@elseif ($user->rol == 50)
  @include('partials.Caja_Chica.menu')
@elseif ($user->rol == 'Credito_Cobranza')
  @include('partials.CreditoCobranza.menu')
@elseif ($user->rol == 500)
  @include('partials.InventarioVentas.menu')
@elseif ($user->rol == "Inventario_Admin")
  @include('partials.InventarioAdmin.menu')
@elseif ($user->rol == "Costo_total_VIN")
  @include('partials.CostoTotalVIN.menu')
@elseif ($user->rol == "Vista_Previa_Movimiento_Exitoso")
  @include('partials.VPMovimientoExitoso.menu')
@endif
@if ($user->rol == 'Taller_Trucks')
  @include('partials.TallerTracktocamiones.menu')
@endif
