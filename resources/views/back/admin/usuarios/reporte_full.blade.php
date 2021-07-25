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
            <th>NOMBRES</th>
            <th>USERNAME</th>
            <th>EMAIL</th>
            <th>ROL</th>
            <th>ESTADO</th>
            <th>CREADO EL</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios->get() as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->estado }}</td>
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