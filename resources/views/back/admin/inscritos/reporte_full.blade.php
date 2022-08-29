<style>
    h2{
        text-align: center;
    }
    th{
        text-align: center;
    }
</style>
<h2>{{ $titulo }}</h2>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>CANTÓN</th>
            <th>PARROQUIA</th>
            <th>TELEFONO</th>
            <th>CREADO EL</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios->get() as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->nombre }}</td>
            <td>{{ $user->parroquia->canton->nombre }}</td>
            <td>{{ $user->parroquia->nombre }}</td>
            <td>{{ $user->telefono }}</td>
            <td>{{ $user->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
    <!-- <tfoot>
        <tr>
            <td colspan="5">Total usuarios: {{ $usuarios->count() }}</td>
        </tr>
    </tfoot> -->
</table>