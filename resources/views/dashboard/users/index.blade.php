@extends('dashboard.layouts.app')

@section('title', 'Users List')

@section('content')
<div class="container">
    <a href="#" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New User</a>
    <a href="{{ route('users.export') }}" class="btn btn-dark mb-3 float-end"><i class="far fa-clock"></i> Export To Excel</a>
    <div class="table-responsive">
        <table class="table no-wrap">
            <thead>
                <tr>
                    <th class="border-top-0">#</th>
                    <th class="border-top-0">Name</th>
                    <th class="border-top-0">Email</th>
                    <th class="border-top-0">Phone</th>
                    <th class="border-top-0">Ip Address</th>
                    <th class="border-top-0">Last Login at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td class="txt-oflo">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td><span class="text-success">{{ $user->ip ? $user->ip : 'Haven\'t Login yet' }}</span></td>
                    <td class="text-success">
                        @if ($user->last_login_at)
                            {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                        @else
                            <span class="badge rounded-pill bg-dark">UnLogged In</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection
