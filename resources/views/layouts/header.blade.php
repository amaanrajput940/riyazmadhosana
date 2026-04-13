@php
$categories = DB::table('categories')->whereNull('parent_id')->get();

$cartCount = DB::table('carts')
    ->where(function($query){
        $query->where('user_id', auth()->id())
              ->orWhere('session_id', session()->getId());
    })
    ->where('quantity','>',0)
    ->sum('quantity');

@endphp
<header class="mnt-header">
    <div class="mnt-container">

        <!-- Logo -->
        <div class="mnt-logo">
            <a href="{{route('home')}}"><img src="{{ asset('assets/img/mntglamtextlogo.png') }}" alt="MNT Glam"></a>
            {{-- <span>MNT </span> <span>Glam</span> --}}
        </div>

        <!-- Menu -->
        <nav class="mnt-menu" id="mntMenu">

            <a href="{{route('home')}}">Home</a>

            <!-- Categories Dropdown -->
            <div class="mnt-dropdown">
                <a href="#">Categories <i class="fas fa-chevron-down"></i></a>

                <div class="mnt-submenu">
    @foreach($categories as $parent)
        <div class="mnt-sub-item">
            <a href="{{ route('category.products', $parent->slug) }}">
                {{ $parent->name }}
            </a>

            @if(!empty($parent->children) && $parent->children->count() > 0)
                <div class="mnt-child-menu">
                    @foreach($parent->children as $child)
                        <a href="{{ route('category.products', $child->slug) }}">
                            {{ $child->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>

            </div>

            {{-- <a href="#">Shop</a> --}}
            <a href="#">About</a>
            <a href="#">Contact</a>

        </nav>

        <!-- Icons -->
        <div class="mnt-actions">
            <i class="fas fa-search"></i>
            <i class="fas fa-user"></i>

            <div class="mnt-cart">
                <a href="{{route('cart')}}" style="color: inherit;">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="mnt-badge" id="cart-count" style="display: none;"></span>
                </a>
            </div>

            <div class="mnt-toggle" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </div>
        </div>

    </div>
</header>

<script>
let initialCartCount = {{ $cartCount ?? 0 }};
document.addEventListener("DOMContentLoaded", function(){

    if(initialCartCount > 0){
        let badge = document.getElementById('cart-count');
        badge.innerText = initialCartCount;
        badge.style.display = 'inline-block';
    }

});
</script>
