import AppHeader from "../Components/AppHeader";
import AppNavigation from "../Components/AppNavigation";

export default function AppLayout({ children, title }) {
    return (
        <>
            <div class="app-layout @yield('layoutClass')">
                <div class="app-layout-column-1">
                    <div class="app-layout-sidebar">
                        <AppNavigation />
                    </div>
                </div>

                <div class="app-layout-column-2">
                    <div class="app-layout-header">
                        <AppHeader />
                    </div>

                    <div class="app-layout-main">
                        <h1 className="app-layout-title border-bottom py-3">
                            {title}
                        </h1>

                        <div class="app-layout-content container">
                            {children}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
