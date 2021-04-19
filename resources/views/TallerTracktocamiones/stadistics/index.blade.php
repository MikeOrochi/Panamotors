@extends('layouts.appAdmin')
@section('titulo', 'Ingreso de tracktocamiones a taller')
@section('content')
  <style media="screen">
  /* Style the form */
  #regForm {
    background-color: #ffffff;
    margin: 100px auto;
    padding: 40px;
    width: 70%;
    min-width: 300px;
  }

  /* Style the input fields */
  input {
    padding: 10px;
    width: 100%;
    font-size: 17px;
    font-family: Raleway;
    border: 1px solid #aaaaaa;
  }

  /* Mark input boxes that gets an error on validation: */
  input.invalid {
    background-color: #ffdddd;
  }

  /* Hide all steps by default: */
  .tab {
    display: none;
  }

  /* Make circles that indicate the steps of the form: */
  .step {
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbbbbb;
    border: none;
    border-radius: 50%;
    display: inline-block;
    opacity: 0.5;
  }

  /* Mark the active step: */
  .step.active {
    opacity: 1;
  }

  /* Mark the steps that are finished and valid: */
  .step.finish {
    background-color: #4CAF50;
  }
  input[type='range'] {
  display: block;
  /* width: 250px; */
}

input[type='range']:focus {
  outline: none;
}

input[type='range'],
input[type='range']::-webkit-slider-runnable-track,
input[type='range']::-webkit-slider-thumb {
  -webkit-appearance: none;
}

input[type=range]::-webkit-slider-thumb {
  background-color: #777;
  width: 20px;
  height: 20px;
  border: 3px solid #333;
  border-radius: 50%;
  margin-top: -9px;
}

input[type=range]::-moz-range-thumb {
  background-color: #777;
  width: 15px;
  height: 15px;
  border: 3px solid #333;
  border-radius: 50%;
}

input[type=range]::-ms-thumb {
  background-color: #777;
  width: 20px;
  height: 20px;
  border: 3px solid #333;
  border-radius: 50%;
}

input[type=range]::-webkit-slider-runnable-track {
  background-color: #777;
  height: 3px;
}

input[type=range]:focus::-webkit-slider-runnable-track {
  outline: none;
}

input[type=range]::-moz-range-track {
  background-color: #777;
  height: 3px;
}

input[type=range]::-ms-track {
  background-color: #777;
  height: 3px;
}

input[type=range]::-ms-fill-lower {
  background-color: HotPink
}

input[type=range]::-ms-fill-upper {
  background-color: black;
}
}
  </style>
  <div class="row mt-3">
    <div class="col-sm-12">
      <div class="shadow panel-head-primary">
        <div class="container" style="padding-bottom: 50px;">
        </div>
      </div>
    </div>
  </div>

    @endsection
