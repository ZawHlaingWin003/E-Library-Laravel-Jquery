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
        @foreach ($admin_users as $admin_user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="txt-oflo">{{ $admin_user->name }}</td>
            <td>{{ $admin_user->email }}</td>
            <td class="txt-oflo">{{ $admin_user->phone }}</td>
            <td><span class="text-success">{{ $admin_user->ip ? $admin_user->ip : 'Haven\'t Login yet' }}</span></td>
            <td class="text-success">
                @if ($admin_user->last_login_at)
                    {{ \Carbon\Carbon::parse($admin_user->last_login_at)->diffForHumans() }}
                @else
                    <span class="badge rounded-pill bg-dark">UnLogged In</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>