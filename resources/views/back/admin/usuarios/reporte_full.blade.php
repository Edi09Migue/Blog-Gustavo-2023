<h2>{{ $titulo }}</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>nombres</th>
            <th>username</th>
            <th>email</th>
            <th>rol</th>
            <th>estado</th>
            <th>Creado el</th>
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
    <tfoot>
        <tr>
            <td colspan="5">Total usuarios: {{ $usuarios->count() }}</td>
        </tr>
    </tfoot>
</table>