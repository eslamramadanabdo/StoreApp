<?php

return [

    [
        'icon'       => 'nav-icon fas fa-tachometer-alt',
        'route'      => 'dashboard.dashboard',
        'text'       => 'Dashboard',
        'activeNow'  => 'dashboard.dashboard'
    ],
    [
        'icon'     => 'far fa-circle nav-icon',
        'route'    => 'dashboard.categories.index',
        'text'     => 'Categories',
        'badge'    => 'New',
        'activeNow'  => 'dashboard.categories.*'
    ],
    [
        'icon'     => 'far fa-circle nav-icon',
        'route'    => 'dashboard.products.index',
        'text'     => 'Products',
        'activeNow'  => 'dashboard.products.*'
    ],


];
