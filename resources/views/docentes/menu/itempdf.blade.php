<style>
    .page-break {
        page-break-after: always;
    }

    .contenedor {
        display: flex;
        flex-direction: column;
        width: 100%;
        justify-content: center;
        align-items: center;
    }

    .lienzo {
        margin: 15px;
    }

    .encabezado {
        display: flex;
        justify-content: space-between;
        margin-bottom: 50px;

    }

    .direccion {
        width: 350px;
    }

    .logo img {
        width: 130px;
    }

    .cuerpo {
        display: flex;
        flex-direction: column;
        margin-bottom: 50px;
    }

    .cuerpo h1 {
        display: flex;
        color: #c0211c;
        justify-content: center;
        align-items: center;
    }

    table {
        border: 1px solid rgb(200, 200, 200);
        border-collapse: collapse;
        font-size: 0.9rem;
        width: 100%;
        margin-top: 1vw;
        margin-bottom: 5vh;
    }

    .titulo {
        display: flex;
        justify-content: center;
        align-items: center;
        color: #c0211c;
        margin: 25px;
        font-size: 1.5rem;
        text-align: center;
    }

    tr {
        text-align: center;
    }

    tr:nth-child(odd) {
        background: rgb(225, 225, 225);
        color: black;

    }

    th {
        background: #c0211c;
        border: 1px solid rgb(160, 160, 160);
        color: rgb(255, 255, 255);
        padding: .8rem;
    }

    td {
        border: 1px solid rgb(160, 160, 160);
        padding: .8rem;
    }

    table tr:hover {
        background: rgb(255, 235, 185);
    }

    .table-container {
        margin: 0 0 1rem;
        overflow: auto;
        overflow-y: auto;
        width: 100%;
    }
    
</style>
<div class="contenedor">
    <div class="lienzo">
        <div class="encabezado">
            <div class="direccion">
                <p>GOBIERNO AUTOMO DEPARTAMENTAL DE LA PAZ
                    DIRECCION DEPARTAMENTAL DE EDUCACION LA PAZ
                    UNIDAD DE ADMINISTRACION DE RECURSOS
                </p>

            </div>
            {{-- <div class="logo">
                <img src="../img/logoayacucho.jpg">
            </div> --}}
        </div>
        <div class="cuerpo">
            <h1>CERTIFICACION PRESUPUESTARIA</h1>
            <p>Presupuesto vigente aprobado, del Instituto Tecnológico "Ayacucho".
                Debido a que todo el proceso e adquisicion se inicia con la certificación presupuestaria del saldo en la
                partida correspondiente;
                El responsable de Bienes y servicios debe ajustarse a los términos de la presente Certificación
            </p>
            <table>
                <thead>
                    <tr>
                        <th>N° Partida</th>
                        <th>Descripcion Partida</th>
                        <th>cantidad</th>
                        <th>Presupuesto vigente</th>
                        <th>precio</th>
                        <th>Descripcion Insumo</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="filas-tabla">
                            {{ $item->peconomica->npartida }}
                        </td>
                        <td class="filas-tabla">
                            {{ $item->peconomica->descripcion }}
                        </td>
                        <td>{{ $item->cantidad }}</td>
                        <td class="filas-tabla">
                            {{ $item->peconomica->monto }}
                        </td>
                        <td class="filas-tabla">
                            {{ $item->costo }}
                        </td>
                        <td class="filas-tabla">
                            {{ $item->descripcion }}
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

</div>
