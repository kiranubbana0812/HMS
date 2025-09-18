<header class="header-top">
    <div class="header-container">
        <!-- Purple Branding Section -->
        <div class="branding-section">
            <div class="branding-content">
                <i class="fas fa-cloud brand-icon"></i>
                <span class="brand-text">CLOUD LABS</span>
            </div>
        </div>
        
        <!-- White Content Section -->
        <div class="header-content">
            <div class="header-left">
                <button class="btn btn-link hamburger-menu" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="header-right">
                {{--<div class="user-profile">
                    <span class="user-name">{{ session('user.name') }}</span>
                    <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=40&h=40&fit=crop" alt="{{ session('user.name') }}" class="profile-img">                                        
                    <div class="profile-dropdown">
                        @if(session('user.role') === 'superadmin')
                        <a href="/doctor/profile" class="dropdown-item">Profile</a>
                        @else
                        <a href="/frontdesk/profile" class="dropdown-item">Profile</a>
                        @endif
                        <a href="javascript:void(0);" class="dropdown-item" id="logout-btn">Logout</a>
                    </div>
                </div>--}}
                @php               
                    $userRole=session('user.role');
                @endphp
                   
<<<<<<< HEAD
                @if($userRole === 'superadmin' || $userRole === 'admin' || $userRole === 'frontdesk' || $userRole === 'pharma')
=======
                @if($userRole === 'superadmin' || $userRole === 'admin' || $userRole === 'frontdesk')
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
                    <div class="user-profile">
                        <span class="user-name">{{ session('user.name') }}</span>
                        <img src="{{ session('user.image') }}?auto=compress&cs=tinysrgb&w=40&h=40&fit=crop" alt="{{ session('user.name') }}" class="profile-img"> 
                        <div class="profile-dropdown">     
                            @if($userRole === 'superadmin')
                                <a href="/superadmin/profile" class="dropdown-item"> Profile</a>
                            @elseif($userRole === 'admin')
                                <a href="/admin/profile" class="dropdown-item"> Profile</a>
                            @elseif($userRole === 'frontdesk')
                                <a href="/frontdesk/profile" class="dropdown-item"> Profile</a>
<<<<<<< HEAD
                            @elseif($userRole === 'pharma')
                                <a href="/pharma/profile" class="dropdown-item"> Profile</a>    
=======
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
                            @endif
                            <a href="javascript:void(0);" class="dropdown-item" id="logout-btn">Logout</a>
                        </div>
                    </div>
                @elseif($userRole === 'doctor')
                    <div class="user-profile">
                        <span class="user-name">{{ session('user.name') }}</span>
                        <img src="{{ session('user.image') }}?auto=compress&cs=tinysrgb&w=40&h=40&fit=crop" alt="{{ session('user.name') }}" class="profile-img">  
                         <div class="profile-dropdown">  
                            <a href="/doctor/profile" class="dropdown-item"> Profile</a>
                            <a href="javascript:void(0);" class="dropdown-item" id="logout-btn">Logout</a>
                        </div>   
                    </div>                   
                @endif
            </div>
        </div>
    </div>
</header>
