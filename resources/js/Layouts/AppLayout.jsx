import AppHeader from "../Components/AppHeader";
import AppNavigation from "../Components/AppNavigation";

export default function AppLayout({ children, title }) {
    return (
        <>
            <div className="app-layout @yield('layoutClass')">
                <div className="app-layout-column-1">
                    <div className="app-layout-sidebar">
                        <AppNavigation />
                    </div>
                </div>

                <div className="app-layout-column-2">
                    <div className="app-layout-header">
                        <AppHeader />
                    </div>

                    <div className="app-layout-main">
                        <h1 className="app-layout-title">{title}</h1>

                        <div className="app-layout-content">{children}</div>
                    </div>
                </div>
            </div>
        </>
    );
}
