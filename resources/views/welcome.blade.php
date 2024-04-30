<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css" />
</head>
<body>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    var alert=function(){
      var not=confirm("¿Estás seguro que quieres eliminar a esta persona?");
      return not;
    }
  </script>

    <div class="modal fade" id="Registrar_persona" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar persona</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route("crud.create")}}" method="post">
               @csrf
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                 name="txtnombre" maxlength="40" required>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                 name="txtapellido" maxlength="40" required>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"> Identificacion</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp
                "name="txtidentificacion" min="0" max="9999999999" required>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Correo</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                 name="txtemail" maxlength="60" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Registrar</button>
              </div>
            </form>
          </div>
           
        </div>
      </div>
    </div>
    <div class="p-5 table-responsive">
      <h1 class=text-center>Registro de personas</h1> 
      @if (session('correcto'))
      <div class="alert alert-info col-md-4" >{{ session('correcto') }}</div>
    @endif


    @if (session('incorrecto'))
    <div class="alert alert-danger col-md-4">{{ session('incorrecto') }}</div>
    @endif
    </br>        
      <button class="btn btn-primary text-dark  m-2"  data-bs-toggle="modal" data-bs-target="#Registrar_persona">
        <i class="fa-solid fa-user-plus"></i>  Nueva Persona</button> 
        <div class="float-end mt-3">
          <a href="{{ route('crud.pdf') }}" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i></a>
          <a href="{{ route('crud.excel') }}" class="btn btn-success ms-2"><i class="fa-solid fa-file-excel"></i></a>
        </div>
        <table id="miTabla" class="table table-striped table-bordered table-hover text-center table-primary">
          <thead class="bg-info">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">Identificación</th>
              <th scope="col">Correo</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody>
            @foreach($datos as $items)       
              <tr>
                  <th scope="row">{{ $items->id }}</th>
                  <td>{{ $items->nombre }}</td>
                  <td>{{ $items->apellido }}</td>
                  <td>{{ $items->identificacion }}</td>
                  <td>{{ $items->correo }}</td>
                  <td>
                    <a href="" data-bs-toggle="modal" data-bs-target="#Editar_persona{{$items->identificacion}}" class="btn btn-sn btn-info text-center ">
                      <i class="fa-solid fa-user-pen"></i>
                    </a>
                  </td>
                  <td>
                    <a href="{{ route("crud.delete",$items->identificacion)}}" onclick="return alert()" class="btn btn-sn btn-danger">
                      <i class="fa-solid fa-user-xmark"></i>
                    </a>
                  </td>
                
              
                <div class="modal fade" id="Editar_persona{{$items->identificacion}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar persona</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="{{ route("crud.update") }}" method="post">
                          @csrf
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            name="txtnombre"  maxlength="40" required value="{{$items->nombre}}">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Apellido</label>
                            <input type="tex" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            name="txtapellido"  maxlength="40" required value="{{$items->apellido}}">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label"> Identificacion</label>
                            <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            name="txtidentificacion" min="0" max="9999999999" required value="{{$items->identificacion}}" readonly>
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            name="txtemail"  maxlength="60" required value="{{$items->correo}}">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Modificar</button>
                          </div>
                        </form>
                      </div>
                     
                    </div>
                  </div>
                </div>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>

    <script src="{{ asset('js/dataTables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/667e90c2c6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.min.js"></script>
    
</body>
</html>