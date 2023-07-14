<header class="main-header">
    <a href="{{route('frontend.home')}}" target="__blank" class="logo">
      <span class="logo-mini"><b>Crt</b></span>
      <span class="logo-lg"><b>Crescent</b></span>
    </a>
    <nav class="navbar navbar-static-top">
       <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              @if(Auth::user()->unreadNotifications->count())
                <span class="label label-warning">{{ Auth::user()->unreadNotifications->count() }}</span>
              @endif
            </a>
            <ul class="dropdown-menu">
              <li>
                <ul class="menu">
                  <li>
                    @if(Auth::user()->unreadNotifications->count())
                      <a href="{{ route('viewer-messages.markAsRead') }}" style="color: #d42222; font-size:12px">Mark all as Read</a>
                    @endif
                  </li>
                  @foreach(Auth::user()->unreadNotifications->take(10) as $unreadNotification)
                    @if(isset($unreadNotification->data['data']))
                      <li>
                        <a>
                          {{ $unreadNotification->data['data'] }}
                        </a>
                      </li>
                    @endif
                  @endforeach
                </ul>
              </li>
              <li class="footer">
                <a href="https://mail.google.com/mail/u/0/#inbox" target="__blank"><i class="fa fa-envelope-o"></i>Check mail</a>
              </li>
            </ul>
          </li>

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if(isset( Auth::user()->profile->image->filename))
                <img src="/storage/media/user/{{Auth::user()->profile->image->filename}}" alt="User Image" class="user-image">
              @else
                <img src="{{asset('images/user2-160x160.jpg')}}" alt="User Image" class="user-image">
              @endif
              <span class="hidden-xs">{{auth()->user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                @if(isset( Auth::user()->profile->image->filename))
                  <img src="/storage/media/user/{{Auth::user()->profile->image->filename}}" alt="User Image" class="img-circle">
                @else
                  <img src="{{asset('images/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                @endif
                <p>
                  {{ auth()->user()->name }}
                  <small>{{ auth()->user()->email }}</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat"  target="_blank">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign out</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
</header>
