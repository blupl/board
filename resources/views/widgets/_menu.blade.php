#{{ $acl = app('orchestra.platform.acl') }}

{{--<ul class="nav navbar-left panel_toolbox" role="tablist">--}}
	{{--@if ($acl->can('manage-roles'))--}}
	{{--<li role="presentation" class="{{ app('request')->is('*control/roles*') ? 'active' : '' }}">--}}
		{{--<a href="{{ handles('orchestra::control/roles') }}">Roles</a>--}}
	{{--</li>--}}
	{{--@endif--}}

	{{--@if ($acl->can('manage-acl'))--}}
	{{--<li role="presentation" class="{{ app('request')->is('*control/acl*') ? 'active' : '' }}">--}}
		 {{--<a href="{{ handles('orchestra::control/acl') }}">ACL</a>--}}
	{{--</li>--}}
	{{--@endif--}}

	{{--@if ($acl->can('manage-orchestra'))--}}
	{{--<li role="presentation" class="dropdown{{ app('request')->is('*control/themes*') ? ' active' : '' }}">--}}
		{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">Themes</a>--}}
		{{--<ul class="dropdown-menu">--}}
			{{--<li>--}}
				{{--<a href="{{ handles('orchestra::control/themes/frontend') }}">Frontend</a>--}}
			{{--</li>--}}
			{{--<li>--}}
				{{--<a href="{{ handles('orchestra::control/themes/backend') }}">Backend</a>--}}
			{{--</li>--}}
		{{--</ul>--}}
	{{--</li>--}}
	{{--@endif--}}
{{--</ul>--}}


<li role="presentation" class="dropdown">
    <a id="" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
        Team
        <span class="caret"></span>
    </a>
    <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
        <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ handles('orchestra::franchise') }}">List</a>
        </li>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ handles('orchestra::franchise') }}">Create</a>
        </li>
        {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="https://twitter.com/fat">Something else here</a>--}}
        {{--</li>--}}
        {{--<li role="presentation" class="divider"></li>--}}
        {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="https://twitter.com/fat">Separated link</a>--}}
        {{--</li>--}}
    </ul>
</li>


