<table class="table table-borderred
 table-hover">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col" style="width: 200px">Email</th>
            <th scope="col">Rol</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if(sizeof($usuarios) > 0)
            @foreach( $usuarios as $usuario)
            <tr>
                <th scope="row">{{ $usuario->id }}</th>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->apellido }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->rol }}</td>
                <td class="d-flex">

                    <!-- Solo los usuarios pueden tener estas opciones, los developers deben ser modificados en la base de datos directamente -->
                    @if($usuario->rol != 'Developer') 
                    <form action="" method="" class="mr-1">
                        @csrf
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Editar">
                            <span class="badge badge-primary py-2" style="width: 25px;" onclick="mostrarmodal({{ $usuario->id }})" data-toggle="modal" data-target="#ModalEditar"><i class="fas fa-pen"></i></span>
                        </a>
                    
                    </form>
                    <form action="{{ route('borrarusuario', $usuario->id) }}" method="delete" class="">
                        @csrf
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Borrar" class="boton-borrar">
                            <span class="badge badge-danger py-2" style="width: 25px;"><i class="fas fa-trash-alt"></i></span>
                        </a>
                    </form>
                    @endif

                </td>
            </tr>
            @endforeach
        @else
        <tr>
            <td colspan="6" class="text-center">No hay datos</td>
        </tr>
        @endif
    </tbody>
</table>
{{ $usuarios->links() }}
<p><b>Usuarios encontrados:</b> {{ sizeof($total)}}</p>


<!-- Modal -->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form url="{{ route('guardarusuario') }}" id="editarusuario">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="Modalnombre" name="nombre" placeholder="Su nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" class="form-control" id="Modalapellido" name="apellido" placeholder="Su apellido" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="Modalemail" name="email" placeholder="ejemplo@airtech.com" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Télefono:</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+</div>
                            </div>
                            <input type="text" class="form-control" id="Modaltelefono" name="telefono" placeholder="414123123" required>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="pais">Pais:</label>
                            <select id="Modalpais" class="form-control" name="pais" required>
                                <option selected value="Venezuela">Venezuela</option>
                                <!-- Tomamos la variable $pais que viene desde el controlador UserController@panelusuarios -->
                                @foreach($paises as $pais)
                                <option value="{{ $pais }}">{{ $pais }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="rol">Rol:</label>
                            <!-- Los roles permitidos hasta el momento, si se alteran debes modificar manualmente las restricciones
                            que existen dentro del sistema, ya que lo diseñe como un string y no como un int, si la cadena varia no
                            funcionará el sistema de jerarquias -->
                            <select id="Modalrol" class="form-control" name="rol" required>
                                <option selected value="Cliente">Cliente</option>
                                <option value="Mecánico">Mecánico</option>
                                <option value="Gerente">Gerente</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" id="Modalid">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="guardarusuario" data-dismiss="modal">Guardar Usuario</button>
                </div>
                <!-- Boton que activa el javascript y envia la peticion AJAX -->
            </form>
        </div>
    </div>
</div>