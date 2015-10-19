<?php $navbar = new Illuminate\Support\Fluent([
    'id'    => 'franchises',
    'title' => 'Franchises',
    'url'   => handles('blupl::franchise'),
    'menu'  => view('blupl/franchises::widgets._menu'),
]); ?>

@decorator('navbar', $navbar)
