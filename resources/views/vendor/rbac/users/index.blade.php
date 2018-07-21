@section('title', 'Users')
@extends('adminlte::page')
@section('content')

    <section class="content container-fluid">
        <div class="user-index">

            <table class="table table-striped table-bordered"><thead>
                <tr>
                    <th>Name</th>
                    <th>Roles</th>
                    <th class="action-column">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('show_user', ['id' => $user->id]) }}">{{ $user->name }}</a>
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                    <a href="{{ route('show_role', ['id' => $role->id]) }}">{{ $role->name }}</a> <br>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('show_user', ['id' => $user->id]) }}" title="View" aria-label="View">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                                <a href="{{ route('edit_user', ['id' => $user->id]) }}" title="Edit" aria-label="Edit">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <a href="{{ route('delete_user', ['id' => $user->id]) }}" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $users->links() }}

        </div>
    </section>

@endsection