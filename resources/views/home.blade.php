@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">DataTable with default features</h3>
  </div>
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th width="40px">ID</th>
          <th width="350px">Nombre</th>
          <th width="350px">Descripción</th>
          <th>Estado</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>
@endsection