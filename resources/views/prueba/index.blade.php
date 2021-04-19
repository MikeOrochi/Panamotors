

@extends('layouts.appAdmin')
@section('titulo', 'Agregar proveedor')
@section('content')
  <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
  <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
  <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet" />
  <form id='myDropzone' action="{{route('video.store')}}" class="dropzone">
    @csrf
  <div class="fallback">
    <input name="file" type="file" accept="video/*" multiple />
  </div>
  <div class="">
    {{-- <button type="button" id="submit-all" class="btn btn-success btn-sm" name="button">Subir</button> --}}
    {{-- <button type="button" id="clear-dropzone" class="btn btn-danger btn-sm" name="button">Limpiar</button> --}}
  </div>
</form>
<script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
<script type="text/javascript">
Dropzone.options.myDropzone = {
  dictDefaultMessage : 'Arrastra los videos aqui para subir',
  dictMaxFilesExceeded : 'Solo se permite subir hasta 5 recursos',
  parallelUploads : 5,
  maxFilesize: 102400,
  acceptedFiles:.mp4,
  init: function() {

    myDropzone = this; // closure
myDropzone.on("error", function(file, errorMessage) {
  //console.log(errorMessage);
  // Handle the responseText here. For example, add the text to the preview element:
  // file.previewTemplate.appendChild(document.createTextNode('Error'));
  file.previewTemplate.appendChild(document.createTextNode('Error al subir'));
  // console.log(errorMessage);
});
myDropzone.on("success", function(file, responseText) {
  //console.log(responseText);
  // Handle the responseText here. For example, add the text to the preview element:
  // file.previewTemplate.appendChild(document.createTextNode(responseText));
  file.previewTemplate.appendChild(document.createTextNode('Listo!'));
});
}
}
</script>
@endsection
