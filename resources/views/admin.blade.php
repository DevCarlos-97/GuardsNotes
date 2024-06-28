@extends('layouts.app')
@extends('layouts.nav')

@section('content')

   <ul class="nav nav-pills" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
         <button class="nav-link active" id="usersView-tab" data-bs-toggle="pill" data-bs-target="#usersView" type="button" role="tab" aria-controls="usersView" aria-selected="true">Usuarios</button>
      </li>
      <li class="nav-item" role="presentation">
         <button class="nav-link" id="ovensView-tab" data-bs-toggle="pill" data-bs-target="#ovensView" type="button" role="tab" aria-controls="ovensView" aria-selected="false">Hornos - Areas</button>
      </li>
      <li class="nav-item" role="presentation">
         <button class="nav-link" id="notesView-tab" data-bs-toggle="pill" data-bs-target="#notesView" type="button" role="tab" aria-controls="notesView" aria-selected="false">Notas</button>
      </li>
   </ul>

   <div class="tab-content" id="pills-tabContent">

      <div class="tab-pane fade show active" id="usersView" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
         <div class="table-responsive card p-4 m-4">
            <h1 class="text-center">Usuarios</h1>
            <button class="btn btn-primary add-note" data-bs-toggle="modal" data-bs-target="#modal_add_user" data-toggle="tooltip" title="Agregar Usuario">
               <i class="bi bi-plus-circle"></i>
            </button>
            <table class="table table-striped table-hover table-bordered" id="table_users">
               <thead>
                  <tr class="text-center">
                     <th>Usuario</th>
                     <th>Nombre</th>
                     <th>Status</th>
                     <th>Rol</th>
                     <th>Opciones</th>
                  </tr>
               </thead>
               <tbody class="table-group-divider">
                  @foreach ($users as $u)
                     <tr>
                        <td class="text-center">{{$u->user}}</td>
                        <td class="text-center">{{$u->name}}</td>
                        <td class="text-center">
                           @if ($u->status==1)
                           <p class="badge text-bg-success">Habilitado</p>
                           @else
                           <p class="badge text-bg-danger">Deshabilitado</p>
                           @endif
                        </td>
                        <td>
                           @if ($u->rol==1)
                              <p class="text-center">Usuario</p>
                           @elseif($u->rol==2)
                              <p class="text-center">Supervisor</p>
                           @else
                              <p class="text-center">Administrador</p>
                           @endif
                        </td>
                        <td class="text-center">
                           @if ($user->id != $u->id)
                              <button class="btn btn-outline-secondary" onclick="getUser({{$u->id}})" data-toggle="tooltip" title="Editar Usuario" data-bs-toggle="modal" data-bs-target="#modal_edit_user">
                                 <i class="bi bi-pencil-square"></i>
                              </button>
                              @if ($u->status == 1)
                                 <button class="btn btn-outline-danger" onclick="toggleStatusUser({{$u->id}})" data-toggle="tooltip" title="deshabilitar">
                                    <i class="bi bi-ban"></i>
                                 </button>
                              @else
                                  <button class="btn btn-outline-success" onclick="toggleStatusUser({{$u->id}})" data-toggle="tooltip" title="habilitar">
                                    <i class="bi bi-check-circle"></i>
                                 </button>
                              @endif
                           @endif
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>

      <div class="tab-pane fade text-center" id="ovensView" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="1">
         <div class="row justify-content-center">
            {{--  Ovens Table--}}
            <div class="table-responsive card p-4 m-4 col-5">
               <h3>Hornos</h3>
               <button class="btn btn-primary add-note" data-bs-toggle="modal" data-bs-target="#modal_add_oven" data-toggle="tooltip" title="Agregar Horno">
                  <i class="bi bi-plus-circle"></i>
               </button>
               <table class="table table-striped table-hover table-bordered w-100" id="table_ovens">
                  <thead>
                     <tr class="text-center">
                        <th>Nombre</th>
                        <th>Area</th>
                        <th>Opciones</th>
                     </tr>
                  </thead>
                  <tbody class="table-group-divider">
                     @foreach ($ovens as $oven)
                     <tr>
                        <td class="text-center">{{$oven->name}}</td>
                        <td class="text-center">{{$oven->area}}</td>
                        <td class="text-center">
                           <button class="btn btn-outline-secondary" onclick="getOven({{$oven->id}})" data-toggle="tooltip" title="Editar Horno" data-bs-toggle="modal" data-bs-target="#modal_edit_oven">
                              <i class="bi bi-pencil-square"></i>
                           </button>
                           @if ($oven->status == 1)
                              <button class="btn btn-outline-danger" onclick="toggleStatusOven({{$oven->id}})" data-toggle="tooltip" title="deshabilitar">
                                 <i class="bi bi-ban"></i>
                              </button>
                           @else
                                 <button class="btn btn-outline-success" onclick="toggleStatusOven({{$oven->id}})" data-toggle="tooltip" title="habilitar">
                                 <i class="bi bi-check-circle"></i>
                              </button>
                           @endif
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
            

            {{-- Areas Table --}}
            <div class="table-responsive card p-4 m-4 col-5">
               <h3>Areas</h3>
               <button class="btn btn-primary add-note" data-bs-toggle="modal" data-bs-target="#modal_add_area" data-toggle="tooltip" title="Agregar Area">
                  <i class="bi bi-plus-circle"></i>
               </button>
               <table class="table table-striped table-hover table-bordered w-100" id="table_areas">
                  <thead>
                     <tr class="text-center">
                        <th>Nombre</th>
                        <th>Responsable</th>
                        <th>Opciones</th>
                     </tr>
                  </thead>
                  <tbody class="table-group-divider">
                     @foreach ($areas as $area)
                        <tr>
                           <td class="text-center">{{$area->name}}</td>
                           <td class="text-center">{{$area->responsible}}</td>
                           <td class="text-center">
                              <button class="btn btn-outline-secondary" onclick="getArea({{$area->id}})" data-toggle="tooltip" title="Editar Area" data-bs-toggle="modal" data-bs-target="#modal_edit_area">
                                 <i class="bi bi-pencil-square"></i>
                              </button>
                              @if ($area->status == 1)
                                 <button class="btn btn-outline-danger" onclick="toggleStatusArea({{$area->id}})" data-toggle="tooltip" title="deshabilitar">
                                    <i class="bi bi-ban"></i>
                                 </button>
                              @else
                                 <button class="btn btn-outline-success" onclick="toggleStatusArea({{$area->id}})" data-toggle="tooltip" title="habilitar">
                                    <i class="bi bi-check-circle"></i>
                                 </button>
                              @endif
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>

      <div class="tab-pane fade" id="notesView" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="2">
         <div class="table-responsive card p-4 m-4">
            <h3 class="text-center">Notas</h3>   
            <table class="table table-striped table-hover table-bordered w-100" id="table_notes">
               <thead>
                  <tr class="text-center">
                     <th class="col-1">Horno</th>
                     <th>Descripcion</th>
                     <th class="col-1">Estado</th>
                     <th>Comentario de guardia</th>
                     <th>Responsable</th>
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
                        <td>{{$note->responsible}}</td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>


   {{--------------- Modals ---------------}}

   {{-- Add User Modal --}}
   <div class="modal fade" id="modal_add_user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h1 class="modal-title fs-5">Agregar usuario</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

               <form id="newUserForm" class="row g-3" method="POST" action="{{route('create-user')}}">
                  @csrf
                  @isset($user_edit)
                     {{$user_edit}} 
                  @endisset
                  <div data-mdb-input-init class="form-outline mb-4">
                     <label class="form-label"><i class="bi bi-person-circle"></i> Nombre</label>
                     <input type="text" name="userName" class="form-control"
                        placeholder="Nombre" required/>
                     </div>
                  
                  <div data-mdb-input-init class="form-outline mb-4">
                     <label class="form-label"> <i class="bi bi-person"></i> Usuario</label>
                     <input type="text" name="user" class="form-control"
                     placeholder="Usuario" required/>
                  </div>
         
                  <div data-mdb-input-init class="form-outline mb-3">
                     <label class="form-label"><i class="bi bi-lock"></i> Contraseña</label>
                     <input type="password" name="password" class="form-control"
                     placeholder="********" required/>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-3">
                     <label class="form-label"><i class="bi bi-lock"></i> Rol</label>
                     <select name="rol" class="form-select form-control" required>
                        <option selected disabled value="">Eliga un rol...</option>
                        <option value="1">Usuario</option>
                        <option value="2">Supervisor</option>
                        <option value="3">Administrador</option>
                     </select>
                  </div>
                  <div class="text-center mt-4 pt-2">
                     <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary loginBtn">Crear usuario</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                  </div>
               </form>

            </div>
         </div>
      </div>
   </div>

   {{-- Edit User Modal --}}
   <div class="modal fade" id="modal_edit_user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h1 class="modal-title fs-5">Editar usuario</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

               <form id="editUserForm" class="row g-3" method="POST" action="{{route('edit-user')}}">
                  @csrf
                  <input type="hidden" id="id_user" name="id_user">
                  <div data-mdb-input-init class="form-outline mb-4">
                     <label class="form-label" for="editUserName"><i class="bi bi-person-circle"></i> Nombre</label>
                     <input type="text" id="editUserName" name="editUserName" class="form-control"
                        placeholder="Nombre" required/>
                     </div>
                  
                  <div data-mdb-input-init class="form-outline mb-4">
                     <label class="form-label" for="editUser"> <i class="bi bi-person"></i> Usuario</label>
                     <input type="text" id="editUser" name="editUser" class="form-control"
                     placeholder="Usuario" required/>
                  </div>
         
                  <div data-mdb-input-init class="form-outline mb-3">
                     <label class="form-label" for="editPassword"><i class="bi bi-lock"></i> Contraseña</label>
                     <input type="password" id="editPassword" name="editPassword" class="form-control"
                     placeholder="********"/>
                  </div>
                  <div data-mdb-input-init class="form-outline mb-3">
                     <label class="form-label" for="editRol"><i class="bi bi-lock"></i> Rol</label>
                     <select name="editRol" id="editRol" class="form-select form-control" required>
                        <option disabled value="">Eliga un rol...</option>
                        <option value="1">Usuario</option>
                        <option value="2">Supervisor</option>
                        <option value="3">Administrador</option>
                     </select>
                  </div>
                  <div class="text-center mt-4 pt-2">
                     <button type="submit" class="btn btn-primary loginBtn">Guardar</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                  </div>
               </form>

            </div>
         </div>
      </div>
   </div>

   {{-- Add Oven Modal --}}
   <div class="modal fade" id="modal_add_oven" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h1 class="modal-title fs-5">Agregar Horno</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="newOvenForm" class="row g-3" method="POST" action="{{route('create-oven')}}">
                  @csrf
                  <div data-mdb-input-init class="form-outline mb-4">
                     <label class="form-label">Nombre del horno:</label>
                     <input type="text" name="ovenName" class="form-control"
                        placeholder="Nombre" required/>
                     </div>
                  
                  <div data-mdb-input-init class="form-outline mb-3">
                     <label class="form-label">Area donde se encuentra:</label>
                     <select name="area_oven" class="form-select form-control" required>
                        <option selected disabled value="">Eliga un area...</option>
                        @foreach ($areas as $area)
                            <option value="{{$area->id}}">{{$area->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="text-center mt-4 pt-2">
                     <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary loginBtn">Guardar</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                  </div>
               </form>

            </div>
         </div>
      </div>
   </div>

   {{-- Edit Oven Modal --}}
   <div class="modal fade" id="modal_edit_oven" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h1 class="modal-title fs-5">Editar Horno</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="editOvenForm" class="row g-3" method="POST" action="{{route('edit-oven')}}">
                  @csrf
                  <input type="hidden" id="id_oven" name="id_oven">
                  <div data-mdb-input-init class="form-outline mb-4">
                     <label class="form-label" for="editOven">Nombre del horno:</label>
                     <input type="text" id="editOven" name="editOven" class="form-control"
                        placeholder="Nombre" required/>
                     </div>
                  
                  <div data-mdb-input-init class="form-outline mb-3">
                     <label class="form-label" for="edit_area_oven">Area donde se encuentra:</label>
                     <select id="edit_area_oven" name="edit_area_oven" class="form-select form-control" required>
                        <option disabled value="">Eliga un area...</option>
                        @foreach ($areas as $area)
                            <option value="{{$area->id}}">{{$area->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  
                  <div class="text-center mt-4 pt-2">
                     <button type="submit" class="btn btn-primary loginBtn">Guardar</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>

   {{-- Add Area Modal --}}
   <div class="modal fade" id="modal_add_area" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h1 class="modal-title fs-5">Agregar Area</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="addAreaForm" class="row g-3" method="POST" action="{{route('create-area')}}">
                  @csrf
                  <div data-mdb-input-init class="form-outline mb-4">
                     <label class="form-label">Nombre del area:</label>
                     <input type="text" name="areaName" class="form-control"
                        placeholder="Nombre" required/>
                     </div>
                  
                  <div data-mdb-input-init class="form-outline mb-3">
                     <label class="form-label">Responsable del area:</label>
                     <select name="user_area" class="form-select form-control" required>
                        <option selected disabled value="">Eliga un responsable...</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="text-center mt-4 pt-2">
                     <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary loginBtn">Guardar</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                  </div>
               </form>

            </div>
         </div>
      </div>
   </div>

   {{-- Edit Area Modal --}}
   <div class="modal fade" id="modal_edit_area" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h1 class="modal-title fs-5">Agregar Area</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="editAreaForm" class="row g-3" method="POST" action="{{route('edit-area')}}">
                  @csrf
                  <input type="hidden" id="id_area" name="id_area">
                  <div data-mdb-input-init class="form-outline mb-4">
                     <label class="form-label" for="editAreaName">Nombre del area:</label>
                     <input type="text" id="editAreaName" name="editAreaName" class="form-control form-control"
                        placeholder="Nombre" required/>
                     </div>
                  
                  <div data-mdb-input-init class="form-outline mb-3">
                     <label class="form-label" for="edit_user_area">Responsable del area:</label>
                     <select name="edit_user_area" id="edit_user_area" class="form-select form-control" required>
                        <option disabled value="">Eliga un responsable...</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="text-center mt-4 pt-2">
                     <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary loginBtn">Guardar</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                  </div>
               </form>

            </div>
         </div>
      </div>
   </div>

@endsection

@section('scripts')
   <script>

      // Scripts User tab
      function toggleStatusUser($id) {
         $.ajax({
            type: 'POST',
            url: '/admin/cambiar-status',
            data: {
               "_token": "{{ csrf_token() }}",
               id: $id
            },
            success: function(response) {
               if (response.status == 'deshabilitado') {
                  Swal.fire({
                     position: "top-end",
                     icon: "success",
                     title: "El usuario se ha deshabilitado",
                     showConfirmButton: false,
                     timer: 1800
                  });
                  setTimeout(() => {
                        location.reload();
                     }, 1500);
               } else{
                  Swal.fire({
                     position: "top-end",
                     icon: "success",
                     title: "El usuario se ha habilitado",
                     showConfirmButton: false,
                     timer: 1800
                  });
                  setTimeout(() => {
                        location.reload();
                     }, 1500);
               }
            }
         })
      }

      function getUser($id) {
         $.ajax({
            type: 'POST',
            url: '/admin/get-user',
            data: {
               "_token": "{{ csrf_token() }}",
               id: $id
            },
            success: function(response) {
               $('#id_user').val(response.id);
               $('#editUserName').val(response.name);
               $('#editUser').val(response.user);
               $('#editRol').val(response.rol);
            }
         });
      }

      // Scripts Ovens-Areas tab

      function getOven($id){
         $.ajax({
            type: 'POST',
            url: 'admin/get-oven',
            data: {
               "_token": "{{ csrf_token() }}",
               id: $id
            },
            success: function(response) {
               $('#id_oven').val(response.id);
               $('#edit_area_oven').val(response.area_id);
               $('#editOven').val(response.name);
            }
         });
      }

      function toggleStatusOven($id) {
         $.ajax({
            type: 'POST',
            url: 'admin/status-oven',
            data: {
               "_token": "{{ csrf_token() }}",
               id: $id
            },
            success: function(response) {
               if (response.status == 'deshabilitado') {
                  Swal.fire({
                     position: "top-end",
                     icon: "success",
                     title: "El Horno se ha deshabilitado",
                     showConfirmButton: false,
                     timer: 1800
                  });
                  setTimeout(() => {
                        location.reload();
                     }, 1500);
               } else{
                  Swal.fire({
                     position: "top-end",
                     icon: "success",
                     title: "El horno se ha habilitado",
                     showConfirmButton: false,
                     timer: 1800
                  });
                  setTimeout(() => {
                        location.reload();
                     }, 1500);
               }
            }
         })
      }

      function getArea($id){
         $.ajax({
            type: 'POST',
            url: 'admin/get-area',
            data: {
               "_token": "{{ csrf_token() }}",
               id: $id
            },
            success: function(response) {
               $('#id_area').val(response.id);
               $('#editAreaName').val(response.name);
               $('#edit_user_area').val(response.user_id);
            }
         });
      }

      function toggleStatusArea($id) {
         $.ajax({
            type: 'POST',
            url: 'admin/status-area',
            data: {
               "_token": "{{ csrf_token() }}",
               id: $id
            },
            success: function(response) {
               if (response.status == 'deshabilitado') {
                  Swal.fire({
                     position: "top-end",
                     icon: "success",
                     title: "El Area se ha deshabilitado",
                     showConfirmButton: false,
                     timer: 1800
                  });
                  setTimeout(() => {
                        location.reload();
                     }, 1500);
               } else{
                  Swal.fire({
                     position: "top-end",
                     icon: "success",
                     title: "El Area se ha habilitado",
                     showConfirmButton: false,
                     timer: 1800
                  });
                  setTimeout(() => {
                        location.reload();
                     }, 1500);
               }
            }
         })
      }

      
         
   </script>

   {{-- Forms Alerts --}}

   @if (Session::has('success'))
   <script>
      Swal.fire({
         position: "top-end",
         icon: "success",
         title: "El usuario se creo correctamente",
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
         title: "El usuario se modifico correctamente",
         showConfirmButton: false,
         timer: 1800
      });
   </script>
   @endif

   @if (Session::has('area'))
   <script>
      Swal.fire({
         position: "top-end",
         icon: "success",
         title: "El area se creo correctamente",
         showConfirmButton: false,
         timer: 1800
      });
   </script>
   @endif

   @if (Session::has('oven'))
   <script>
      Swal.fire({
         position: "top-end",
         icon: "success",
         title: "El area se creo correctamente",
         showConfirmButton: false,
         timer: 1800
      });
   </script>
   @endif

   @if (Session::has('edit-oven'))
   <script>
      Swal.fire({
         position: "top-end",
         icon: "success",
         title: "El horno se edito correctamente",
         showConfirmButton: false,
         timer: 1800
      });
   </script>
   @endif

   @if (Session::has('edit-area'))
   <script>
      Swal.fire({
         position: "top-end",
         icon: "success",
         title: "El area se edito correctamente",
         showConfirmButton: false,
         timer: 1800
      });
   </script>
   @endif
@endsection