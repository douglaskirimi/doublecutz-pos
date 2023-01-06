<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
    <!-- <div class="app-sidebar__user">
    
        <div>
            <p class="app-sidebar__user-name">{{ Auth::user()->fullname }}</p>
            <p class="app-sidebar__user-designation">Owner</p>
        </div>
    </div> -->
    <ul class="app-menu">
        <li><a class="app-menu__item active" href="/"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>


        <li class="treeview bg-primary"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-indent"></i><span class="app-menu__label">CASHIER</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item " href="{{route('invoice.create')}}"><i class="icon fa fa-plus"></i>Record Sales </a></li>
          
                <li><a class="treeview-item " href="{{route('process','1')}}"><i class="icon fa fa-industry"></i>Manage Sales</a></li>
                <li><a class="treeview-item " href="{{route('process','2')}}"><i class="icon fa fa-file"></i>Reports</a></li>
                <!-- <li><a class="treeview-item" href="{{route('process','3')}}"><i class="icon fa fa-edit"></i>Proccessed </a></li> -->
            </ul>
        </li>
        <li class="treeview "><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-industry"></i><span class="app-menu__label">Categories</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item " href="{{route('category.create')}}"><i class="icon fa fa-plus"></i>Add Category</a></li>
                <li><a class="treeview-item" href="{{route('category.index')}}"><i class="icon fa fa-circle-o"></i>Manage Categories</a></li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-briefcase"></i><span class="app-menu__label">Services</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('service.create')}}"><i class="icon fa fa-plus"></i> Add Service</a></li>
                <li><a class="treeview-item" href="{{route('service.index')}}"><i class="icon fa fa-circle-o"></i> Manage Services</a></li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Customers</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('customer.create')}}"><i class="icon fa fa-plus"></i> Add Customer</a></li>
                <li><a class="treeview-item" href="{{route('customer.index')}}"><i class="icon fa fa-circle-o"></i> Manage Customers</a></li>
            </ul>
        </li>

<!--         <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-object-group"></i><span class="app-menu__label">Commissions</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('tax.create')}}"><i class="icon fa fa-circle-o"></i> Add Commission</a></li>
                <li><a class="treeview-item" href="{{route('tax.index')}}"><i class="icon fa fa-circle-o"></i> Manage Commission</a></li>
             </ul>
        </li> -->

             <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-object-group"></i><span class="app-menu__label">Reports</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{ route('daily_sales') }}"><i class="icon fa fa-circle-o"></i>Daily Sales</a></li>
                <li><a class="treeview-item" href="{{ route('daily_commission') }}"><i class="icon fa fa-circle-o"></i> Daily Commission</a></li>
             </ul>
        </li>

<!--         <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-bars"></i><span class="app-menu__label">Payments</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('receipt.create')}}"><i class="icon fa fa-circle-o"></i> Add payment</a></li>
                <li><a class="treeview-item" href="{{route('receipt.index')}}"><i class="icon fa fa-circle-o"></i> Manage Payments</a></li>
            </ul>
        </li> -->

<!--         <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-handshake-o"></i><span class="app-menu__label">Supplier</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('supplier.create')}}"><i class="icon fa fa-circle-o"></i> Add Supplier</a></li>
                <li><a class="treeview-item" href="{{route('supplier.index')}}"><i class="icon fa fa-circle-o"></i> Manage Suppliers</a></li>
            </ul>
        </li> -->

             
        @if(Auth::user()->usergroup_id==1)
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Employees</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('user.create')}}"><i class="icon fa fa-circle-o"></i> Add Employee</a></li>
                <li><a class="treeview-item" href="{{route('user.index')}}"><i class="icon fa fa-circle-o"></i> Manage Employees</a></li>
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Roles And Permissions</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('role.create')}}"><i class="icon fa fa-circle-o"></i> Add Role</a></li>
                <li><a class="treeview-item" href="{{route('role.index')}}"><i class="icon fa fa-circle-o"></i> Manage Roles</a></li>
            </ul>
        </li>
        @endif

    </ul>
</aside>