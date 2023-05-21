<div class="app-navigation">
    <ul>
        <li>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <div>Settings</div>
            <ul>
                <li>
                    <a href="{{ route('settings.wards') }}">Wards</a>
                </li>
                <li>
                    <a href="{{ route('settings.gnDivisions') }}">GN Divisions</a>
                </li>
            </ul>
        </li>
        <li class="mt-4 border-top py-2">

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    {{ __('Logout') }}
                </button>
            </form>

        </li>
    </ul>
</div>
