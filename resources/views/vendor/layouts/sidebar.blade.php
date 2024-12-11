<div class="dashboard_sidebar">
    <span class="close_icon">
      <i class="far fa-bars dash_bar"></i>
      <i class="far fa-times dash_close"></i>
    </span>

    <a href="dsahboard.html" class="dash_logo"><img src="{{ asset('frontend/images/logo.png') }}" alt="logo"
                                                    class="img-fluid"></a>
    <ul class="dashboard_link">
        <li><a class="{{ set_active(['vendor.dashboard']) }}" href="{{ route('vendor.dashboard') }}"><i class="fas fa-tachometer"></i>Dashboard</a></li>
        <li><a class="{{ set_active(['vendor.products.*']) }}" href="{{ route('vendor.products.index') }}"><i class="fas fa-box"></i> Products</a></li>
        <li><a class="{{ set_active(['vendor.shop-profile']) }}" href="{{ route('vendor.shop-profile.index') }}"><i class="fas fa-briefcase"></i> Shop Profile</a></li>
        <li><a class="{{ set_active(['']) }}" href="{{ route('vendor.profile') }}"><i class="far fa-user"></i> My Profile</a></li>
        <li>
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    <i class="far fa-sign-out-alt"></i>
                    Log out</a>
            </form>

        </li>


    </ul>
</div>
