@extends('layouts.app')

@vite(['resources/css/login-register.css'])

@section('content')
   <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h1>Registro</h1>
            </div>
            <div class="card-body">
              @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                      @endforeach
                  </ul>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
                <section class="vh-32">
                    <div class="container-fluid h-custom">
                      <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-9 col-lg-6 col-xl-5">
                          <img src="{{asset('images/Logo.png')}}"
                            class="img-fluid" alt="Sample image">
                        </div>
                        <div class="col-md-8 col-lg-6 offset-xl-1">
                          <form action="{{route('register')}}" method="POST">
                            @csrf    
                            
                            <div data-mdb-input-init class="form-outline mb-4">
                              <label class="form-label" for="userName"><i class="bi bi-person-circle"></i> Nombre</label>
                                <input type="text" id="userName" name="userName" class="form-control form-control-lg"
                                  placeholder="Nombre" required/>
                              </div>
                            
                            <div data-mdb-input-init class="form-outline mb-4">
                              <label class="form-label" for="user"> <i class="bi bi-person"></i> Usuario</label>
                              <input type="text" id="user" name="user" class="form-control form-control-lg"
                                placeholder="Usuario" required/>
                            </div>
                  
                            <div data-mdb-input-init class="form-outline mb-3">
                              <label class="form-label" for="password"><i class="bi bi-lock"></i> Contraseña</label>
                              <input type="password" id="password" name="password" class="form-control form-control-lg"
                                placeholder="********" required/>
                            </div>
                            <div class="text-center mt-4 pt-2">
                              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary loginBtn">Registro</button>
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