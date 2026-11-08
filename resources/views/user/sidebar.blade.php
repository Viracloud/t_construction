<ul>
    <li>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fa-regular fa-user"></i> Dashboard</a>
    </li>
    <li>
        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}"><i class="fa-regular fa-pen-to-square"></i> Profile</a>
        </li>
    @if(config('app.shop_enabled'))
    <li>
        <a href="{{ route('orders') }}" class="{{ request()->routeIs('orders') || request()->routeIs('invoice') ? 'active' : '' }}"><i class="fa-regular fa-bag-shopping"></i> My Orders</a>
    </li>
    <li>
        <a href="{{ route('reviews') }}" class="{{ request()->routeIs('reviews') ? 'active' : '' }}"><i class="fa-regular fa-star"></i> My Reviews</a>
    </li>
    <li>
        <a href="{{ route('wishlist') }}" class="{{ request()->routeIs('wishlist') ? 'active' : '' }}"><i class="fa-regular fa-heart"></i> Wishlist</a>
    </li>
    @endif
    <li>
        <a href="{{ route('logout') }}" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
    </li>
</ul>
