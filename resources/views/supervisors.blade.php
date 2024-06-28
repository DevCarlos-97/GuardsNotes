@extends('layouts.app')
@extends('layouts.nav')

@section('content')

<div class="table-responsive card p-4 m-5">
   <h1 class="text-center">Notas</h1>
   <button class="btn btn-primary add-note" data-bs-toggle="modal" data-bs-target="#modal_add_note" data-toggle="tooltip" title="Agregar Nota">
      <i class="bi bi-plus-circle"></i>
   </button>
   <table class="table table-striped table-hover table-bordered" id="table_notes">
      <thead>
         <tr class="text-center">
            <th class="col-1">Horno</th>
            <th>Descripcion</th>
            <th class="col-1">Estado</th>
            <th>Comentario de guardia</th>
            <th class="col-1">Opciones</th>
         </tr>
      </thead>
      <tbody class="table-group-divider">
         @foreach ($notes as $note)
         <tr>
            <td class="text-center">{{$note->oven}}</td>
            <td>{{$note->description}}</td>
            <td class="text-center">
               @if ($note->status==1)
               <p class="badge text-bg-warning">En proceso</p>
               @else
               <p class="badge text-bg-success">Terminado</p>
               @endif
            </td>
            <td>{{$note->comment}}</td>
            <td class="text-center">
               @if ($note->status==1)
                  <button class="btn btn-outline-secondary" onclick="editNote({{$note->id}})" data-toggle="tooltip" title="Editar Nota" data-bs-toggle="modal" data-bs-target="#modal_edit_note">
                     <i class="bi bi-pencil-square"></i>
                  </button>
                  <button class="btn btn-outline-danger" onclick="deleteNote({{$note->id}})" data-toggle="tooltip" title="Eliminar Nota">
                     <i class="bi bi-trash3"></i>
                  </button>
               @endif
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>


{{-- Add Note Modal --}}
<div class="modal fade" id="modal_add_note" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar nota</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">

            <form id="newNoteForm" class="row g-3" method="POST" action="{{route('create_note')}}">
               @csrf
               <div class="col-md-8">
                  <label for="oven" class="form-label">Horno:</label>
                  <select class="form-select form-control" id="oven" name="oven" required>
                     <option selected disabled value="">Eliga un horno...</option>
                     @foreach ($ovens as $oven)
                        <option value="{{$oven->name}}">{{$oven->name}}</option> 
                     @endforeach
                  </select>
               </div>
               <div class="col-md-8">
                  <label for="time" class="form-label">Hora:</label>
                  <input type="time" name="time" id="time" class="form-control" required>
               </div>
               <div class="col-md-12">
                  <label for="instructions" class="form-label">Instrucciones:</label>
                  <textarea class="form-control" id="instructions" name="instructions" rows="5"></textarea>
                  {{-- @error('instructions')
                      <span>{{$message}}</span>
                  @enderror --}}
               </div>
               <div class="col-12 ">
                  <button class="btn btn-primary" type="submit">Crear nota</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
               </div>
            </form>

         </div>
      </div>
   </div>
</div>

{{-- Edit Note Modal --}}

<div class="modal fade" id="modal_edit_note" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="editNoteLabel">Editar nota</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form class="row g-3" method="POST" action="{{route('edit_note')}}">
               @csrf
               <div class="col-md-8">
                  <input type="hidden" id="id_note" name="id_note">
                  <label for="oven" class="form-label">Horno:</label>
                  <select class="form-select form-control" id="edit_oven" name="edit_oven" required>
                     <option disabled>Eliga un horno...</option>
                     @foreach ($ovens as $oven)
                        <option value="{{$oven->name}}">{{$oven->name}}</option>  
                     @endforeach
                  </select>
               </div>
               <div class="col-md-12">
                  <label for="instructions" class="form-label">Instrucciones:</label>
                  <textarea class="form-control" id="edit_instructions" name="edit_instructions" rows="5" required></textarea>
               </div>
               <div class="col-12 ">
                  <button class="btn btn-primary" type="submit">Editar nota</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


@endsection

@section('scripts')
   <script>
      function editNote($id) {
         $.ajax({
            type: 'POST',
            url: '/supervisores/nota',
            data: {
               "_token": "{{ csrf_token() }}",
               id: $id
            },
            success: function(response) {
               $('#id_note').val(response.id);
               $('#edit_oven').val(response.oven);
               $('#edit_instructions').val(response.description);
            }
         });
      }

      function deleteNote($id){
         Swal.fire({
            title: "Esta seguro que desea eliminar la nota?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Eliminar"
         }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                  type: 'POST',
                  url: '/supervisores/eliminar',
                  data: {
                     "_token": "{{ csrf_token() }}",
                     id: $id
                  }, 
                  success: function(response) {
                     Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "La nota se elimino correctamente",
                        showConfirmButton: false,
                        timer: 1800
                     });
                     setTimeout(() => {
                        location.reload();
                     }, 1500);
                  }
               });
            }
         });
      }
   </script>

   @if (Session::has('success'))
       <script>
         Swal.fire({
            position: "top-end",
            icon: "success",
            title: "La nota se creo correctamente",
            showConfirmButton: false,
            timer: 1800
         });
       </script>
   @endif

   @if (Session::has('edit'))
       <script>
         Swal.fire({
            position: "top-end",
            icon: "success",
            title: "La nota se edito correctamente",
            showConfirmButton: false,
            timer: 1800
         });
       </script>
   @endif
   
@endsection
