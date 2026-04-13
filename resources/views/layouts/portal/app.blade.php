<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title','Dashboard')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* Sidebar Desktop Style */
.sidebar{
    width: 250px;
    min-height: 100vh;
    transition: 0.3s;
    background:#212529;
    color:white;
}

/* Sidebar Menu Links */
.sidebar .nav-link{
    color:white;
}

/* Mobile Drawer */
@media(max-width:768px){

    .sidebar{
        position: fixed;
        left:-260px;
        top:0;
        height:100%;
        z-index:1050;
    }

    .sidebar.active{
        left:0;
    }
}

</style>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body>

<div class="d-flex">

<!-- Sidebar -->
<div id="sidebar" class="sidebar p-3">

    <h4 class="text-center">Admin Panel</h4>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">

        <li class="nav-item">
            <a href="{{ route('dashboard.home') }}" class="nav-link">
                Dashboard
            </a>
        </li>

        <li>
            <a href="#" class="nav-link">Users</a>
        </li>

        <li>
            <a href="{{ route('dashboard.categories.index') }}" class="nav-link">
                Categories
            </a>
        </li>

        <li>
            <a href="{{ route('dashboard.products.index') }}" class="nav-link">
                Products
            </a>
        </li>

        <li>
            <a href="{{ route('dashboard.orders.list') }}" class="nav-link">
                Orders
            </a>
        </li>

    </ul>

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger w-100">Logout</button>
    </form>

</div>

<!-- Main Content -->
<div class="flex-grow-1">

<!-- Navbar -->
<nav class="navbar navbar-light bg-light shadow-sm px-4">

<div class="d-flex align-items-center gap-2">

<button class="btn btn-dark d-lg-none" id="menuToggle">
☰
</button>

<span class="navbar-brand">
Welcome, {{ auth()->user()->name ?? 'Admin' }}
</span>

</div>

</nav>

<!-- Page Content -->
<div class="container-fluid p-4">

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

@yield('content')

</div>

</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- 4️⃣ DataTables (optional) -->
<link rel="stylesheet"
 href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- 5️⃣ Your custom scripts -->
@stack('scripts')

<script>
$(document).on('click','#menuToggle',function(){
    $('#sidebar').toggleClass('active');
});
</script>
</body>
</html>


