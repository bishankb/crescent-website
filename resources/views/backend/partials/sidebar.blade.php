<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a href="/admin">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview {{ Request::is('admin/categories*') ||
                    Request::is('admin/tags*') ||
                    Request::is('admin/blogs*')
                    ? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Blog</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/categories*') ? 'active' : ''}}">
                        <a href="{{route('categories.index')}}">
                          <i class="fa fa-list"></i><span>Category</span>
                        </a>
                    </li>
                    <li class="{{Request::is('admin/tags*') ? 'active' : ''}}">
                        <a href="{{route('tags.index')}}">
                          <i class="fa fa-tags"></i><span>Tags</span>
                        </a>
                    </li>
                    @can('view_blogs')
                        <li class="{{Request::is('admin/blogs*') ? 'active' : ''}}">
                            <a href="{{route('blogs.index')}}">
                              <i class="fa fa-book"></i><span>Blogs</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @can('view_products')
                <li class="{{Request::is('admin/features*') ? 'active' : ''}}">
                    <a href="{{route('features.index')}}">
                      <i class="fa fa-star"></i><span>Feature</span>
                    </a>
                </li>
            @endcan
            @can('view_products')
                <li class="{{Request::is('admin/products*') ? 'active' : ''}}">
                    <a href="{{route('products.index')}}">
                      <i class="fa fa-shopping-cart"></i><span>Product</span>
                    </a>
                </li>
            @endcan
            @can('view_services')
                <li class="{{Request::is('admin/services*') ? 'active' : ''}}">
                    <a href="{{route('services.index')}}">
                      <i class="fa fa-cogs"></i><span>Service</span>
                    </a>
                </li>
            @endcan
            @can('view_users')
                <li class="{{Request::is('admin/users*') ? 'active' : ''}}">
                    <a href="{{route('users.index')}}">
                      <i class="fa fa-user"></i><span>User</span>
                    </a>
                </li>
            @endcan
            <li class="{{Request::is('admin/contact-us*') ? 'active' : ''}}">
                <a href="{{route('contact-us.edit')}}">
                  <i class="fa fa-phone"></i><span>Contact Us</span>
                </a>
            </li>

            <li class="{{ Request::is('admin/bulksms*') ? 'active' : '' }}">
                <a href="{{ route('bulksms.index') }}">
                    <i class="fa fa-envelope-o"></i><span>Bulk SMS</span>
                </a>
            </li>

            <li class="{{ Request::is('admin/phonebooks*') ? 'active' : '' }}">
                <a href="{{ route('phonebooks.index') }}">
                    <i class="fa fa-book"></i><span>Phone Book</span>
                </a>
            </li>
            
            <li class="header">Misc</li>
            @can('view_roles')
                <li class="{{ Request::is('admin/roles*') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}">
                        <i class="fa fa-adn"></i><span>Roles</span>
                    </a>
                </li>
            @endcan
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
