<span class="profile-card-inline d-flex align-items-center gap-2">

    @include('components.profileIcon')

    <span>
        <div>
            {{ Auth::user()->first_name }}

            @if (Auth::user()->last_name)
                {{ Auth::user()->last_name }}
            @endif
        </div>

        <div class="user-role small">
            @switch(Auth::user()->user_type)
                @case('admin')
                    Admin
                @break

                @case('gn')
                    Grama Niladhari
                @break

                @case('sn')
                    Samurdhi Niladhari
                @break

                @default
                    User
            @endswitch
        </div>
    </span>
</span>
