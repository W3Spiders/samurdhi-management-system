<div class="app-navigation">
    <ul>
        <li>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li>
            <div>Settings</div>
            <ul>
                <li>
                    <a href="{{ route('admin.settings.ward.manage') }}">Wards</a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.gn-division.manage') }}">GN Divisions</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
