@extends('app')
@section('content')
<div class="container">
  <h1 class="my-4">Potpisi PDF</h1>
  @include('common.alert')
  <form id="pdf-form" action="{{ route('sign-pdf.store') }}" enctype="multipart/form-data" method="POST">
    @csrf
    <div>
      <label>Izaberi PDF:</label>
    </div>
    <input id="pdf-file" type="file" name="pdf" accept="application/pdf">
    <div class="pdf-error text-danger"></div>
    @error('pdf')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <div class="mt-3">
      <h3>Kreiraj potpis</h3>
      <canvas id="signature" class="border" width=400 height=200></canvas>
      <div class="signature-error text-danger"></div>
      @error('signature')
      <div class="text-danger">{{ $message }}</div>
      @enderror
      <input id="signature-input" type="hidden" name="signature">
    </div>
    <div>
      <button type="button" id="clear" class="btn btn-secondary">Obriši potpis</button>
    </div>
    <div>
      <button id="potpis-btn" type="submit" class="btn btn-primary mt-4">Potpisi </button>
    </div>
  </form>
</div>
<img src="" alt="">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
  var canvas = document.getElementById('signature')

  var signaturePad = new SignaturePad(canvas)

  const form = document.getElementById('pdf-form')

  form.addEventListener('submit', (e) => {
    e.preventDefault()
    document.getElementById("potpis-btn").disabled = true;
    const valid = validateForm()

    if(valid) {
      const signatureInput = document.getElementById('signature-input');
      signatureInput.value = signaturePad.toDataURL()
      form.submit()
    } else {
      document.getElementById("potpis-btn").disabled = false;
    }
  });

  function validateForm() {
    const pdf = document.getElementById('pdf-file')
    const errPdf = document.querySelector('.pdf-error')
    const errSignature = document.querySelector('.signature-error')
    errSignature.textContent = ''
    errPdf.textContent = ''
    var error = false
    if(signaturePad.isEmpty()) {
      errSignature.textContent = 'Signature is required.'
      error = true
    }

    if(pdf.value === '') {
      errPdf.textContent = 'PDF is required.'
      error = true
    }
    return !error
  }


  document.getElementById('clear').addEventListener('click', function () {
    signaturePad.clear()
  });

</script>

@endsection
