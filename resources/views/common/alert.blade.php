@if(session()->has('alert') || isset($alert))
@php
$alert = session()->get('alert') ?? $alert;
@endphp
<div id="alert" class="alert row alert-{{$alert->status}} alert-dismissible pe-0 fade show" role="alert">
  <div class="col-12">
    <strong class="font-weight-bold">{{ $alert->title }} </strong> {{$alert->message}}
  </div>
</div>
@endif
