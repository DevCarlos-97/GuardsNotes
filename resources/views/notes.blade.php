@extends('layouts.app')
@extends('layouts.nav')

@section('content')

    <h1>Tareas a realizar</h1>

    <section class="notes_container">
        @foreach ($notes as $note)
            <div class="card" style="height: 31rem">
                <div class="card-header text-center">
                    <h1>Horno {{$note->oven}}</h1>
                </div>
                <div class="card-body">
                    <p>Area: {{$note->name}}</p>
                    <p>Instrucciones:</p>
                    <textarea name="instructions" cols="30" rows="3" disabled>{{$note->description}}</textarea>
                    <p>Comentario:</p>
                    <textarea id="guardComment-{{$note->id}}" name="guardComment" cols="30" rows="4"></textarea>
                </div>
                <div class="card-footer d-grid gap-2 col-12 mx-auto">
                    <button type="submit" class="btn btn-primary" onclick="noteDone({{$note->id}})">Hecho</button>
                </div>
            </div>
        @endforeach
    </section>
@endsection

@section('scripts')
    <script>
        function noteDone($id, $key) {
            var $comment = $('#guardComment-'+$id).val();
            Swal.fire({
                title: "Esta seguro de que termino la nota?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/notes/done',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: $id,
                            comment: $comment
                        }, 
                        success: function(response) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "La nota se realizó correctamente",
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
@endsection