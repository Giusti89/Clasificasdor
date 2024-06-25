<div>
   
    <div class="contenedor">
      <link rel="stylesheet" href="../../css/usuarios.css">
      <div class="botones">
          <div>
              <x-layouts.btnconfirmar contenido="Crear Carrera" enlace="administracion.carreras.nuevo">
              </x-layouts.btnconfirmar>
          </div>
          <div>
              <label for="filtro">Filtrar por nombre: </label>
              <input type="text" wire:model.live="search">
          </div>
          <div>
              <label for="filtro">Paginas: </label>
              <input type="number" wire:model.live="paginate" min="1">
          </div>
      </div>
      <div class="table-container">
          <table>
              <thead>
                  <tr>
                      
                      <th>Carrera</th>
                      <th>Presupuesto</th>
                      <th>Asignacion de personal</th>
                      <th>Modificación</th>
                      <th>Eliminar</th>
                  </tr>
              </thead>
              <tbody>
                  {{-- @foreach ($carrera as $carr)
                     
                          <tr>
                            
                              <td class="filas-tabla">
                                  {{ $carr->nombre }}
                              </td>

                              <td class="filas-tabla">
                                  {{ $carr->presupuesto }}
                              </td>

                              

                              <td class="filas-tabla">
                                  <div>

                                      <a href="{{ route('asigCarr',  $carr->id) }}">
                                          <button type="button" class="asigna">
                                              Asignar Personal
                                          </button>
                                      </a>
                                     

                                  </div>
                              </td>
                              <td class="filas-tabla">
                                  <div>
                                      <x-layouts.btnenviodat rutaEnvio="adminedi" dato="{{ $carr->id }}"
                                          nombre="Modificar datos">
                                      </x-layouts.btnenviodat>
                                  </div>
                              </td>
                              <td class="filas-tabla">
                                  <div>
                                      <form class="eli" action="{{ route('eliCarrera', $carr->id) }}"
                                          method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <x-layouts.btnelim contenido="Eliminar">
                                          </x-layouts.btnelim>
                                      </form>
                                  </div>
                              </td>
                          </tr>
                      
                  @endforeach --}}
              </tbody>
          </table>
          {{-- {{ $carrera->links() }} --}}
      </div>
  </div>
  @section('js')
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
          $('.eli').submit(function(e) {
              e.preventDefault()

              Swal.fire({
                  title: "¿Estas seguro de eliminar esta carrera?",
                  text: "¡No podrás revertir esto!",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Si, eliminar"
              }).then((result) => {
                  if (result.value) {
                      this.submit();
                  }
              });
          });
      </script>
  @endsection
</div>
