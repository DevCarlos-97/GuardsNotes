@extends('layouts.app')

@vite(['resources/css/login-register.css'])

@section('content')

   <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h1>Login</h1>
            </div>
            <div class="card-body">
                <section class="vh-32">
                    <div class="container-fluid h-custom">
                      <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-9 col-lg-6 col-xl-5">
                          <img src="{{asset('images/Logo.png')}}"
                            class="img-fluid" alt="Sample image">
                        </div>
                        <div class="col-md-8 col-lg-6 offset-xl-1">
                          <form action="{{route('login')}}" method="POST">
                            @csrf        
                            <div data-mdb-input-init class="form-outline mb-4">
                              <input type="text" id="user" name="user" class="form-control form-control-lg"
                              placeholder="Usuario" required/>
                              <i class="bi bi-person"></i>
                              <label class="form-label" for="user">Usuario</label>
                            </div>
                  
                            <div data-mdb-input-init class="form-outline mb-3">
                              <input type="password" id="password" name="password" class="form-control form-control-lg"
                                placeholder="********" required/>
                                <i class="bi bi-lock"></i>
                              <label class="form-label" for="password">Contraseña</label>
                            </div>
                            <div class="text-center mt-4 pt-2">
                              <button type="submit" class="btn btn-primary loginBtn">Login</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </section>
            </div>
        </div>
   </div>
@endsection
@section('scripts')
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
  @if (Session::has('status'))
    <script>
      Swal.fire({
        title: "Usuario deshabilitado",
        text: "Favor de hablar con el administrador del sistema",
        icon: "error"
      });
    </script>
  @endif
  @if (Session::has('error'))
    <script>
      Swal.fire({
        title: "Usuario incorrecto",
        text: "Datos ingresados no son correctos, favor de verificar",
        icon: "error"
      });
    </script>
  @endif
@endsection