@extends('app')
@section('content')
<div class="container">
  <h1 class="my-4">Potpisani</h1>
  @include('common.alert')
  <table id="signed-pdf-table" class="table table-striped" style="width:100%">
    <thead>
      <tr>
        <th>Ime</th>
        <th>Datum</th>
        <th>Original</th>
        <th>Potpisan</th>
      </tr>
    </thead>
  </table>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function() {
    $('#signed-pdf-table').DataTable({
        processing: true,
        serverSide: true,
        order: [[ 1, 'desc' ]],
        pageLength: 25,
        ajax: "{{ route('sign-pdf.datatable-api') }}",
        columns: [
            { data: 'name', name: 'cleanPdf.name' },
            { data: 'created_at', name: 'created_at', searchable: false },
            { data: 'cleanPath', name: 'cleanPdf.path', sortable: false, searchable:false },
            { data: 'path', name: 'path', sortable: false, searchable:false },
        ]
    });
});
</script>
@endsection

@section ('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endsection
