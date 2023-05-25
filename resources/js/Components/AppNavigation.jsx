export default function AppNavigation() {
    return (
        <div className="app-navigation">
            <div className="brand-container"></div>

            <ul className="list-unstyled m-0 p-0">
                <li>
                    <a href={route("dashboard")}>Dashboard</a>
                </li>
                <li>
                    <a href={route("familyUnits")}>Family Units</a>
                </li>
                <li>
                    <a href={route("settings.wards")}>Wards</a>
                </li>
                <li>
                    <a href={route("settings.gnDivisions")}>GN Divisions</a>
                </li>
            </ul>
        </div>
    );
}
