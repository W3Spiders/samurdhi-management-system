export default function AppNavigation() {
    return (
        <div class="app-navigation">
            <div class="brand-container"></div>

            <ul class="list-unstyled">
                <li>
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('familyUnits') }}">Family Units</a>
                </li>
                <li>
                    <a href="{{ route('settings.wards') }}">Wards</a>
                </li>
                <li>
                    <a href="{{ route('settings.gnDivisions') }}">
                        GN Divisions
                    </a>
                </li>
            </ul>
        </div>
    );
}
