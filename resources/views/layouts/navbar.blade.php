<nav class="navbar navbar-expand navbar-light bg-white shadow-sm px-4">
    <span class="navbar-brand fw-semibold">
        Dashboard
    </span>

    <div class="ms-auto dropdown">
        <a class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
            {{ auth()->user()->name }}
            <small class="text-muted">
                ({{ auth()->user()->role->name }})
            </small>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
