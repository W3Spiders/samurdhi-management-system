export default function AppHeader() {
    return (
        <header className="app-header">
            {/* <a href="#" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-offset="0,18">
        @include('components.profileIcon')
    </a> */}

            <div className="dropdown-menu">
                {/* <div class="px-3 py-2 mb-2 border-bottom">
            @include('components.profileCardInline')
        </div>

        <ul class="list-unstyled m-0">
            <li>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        {{ __('Logout') }}
                    </button>
                </form>
            </li>
        </ul> */}
            </div>
        </header>
    );
}
