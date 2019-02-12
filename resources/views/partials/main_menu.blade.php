<nav class="navbar navbar-expand-sm navbar-default">
    <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
            @php
                $user=auth()->user();
            @endphp
            @foreach(menu() as $item)
                @if($user->perfil <= $item->permissions)
                    @if($item->subItems->count())
                        <li class="menu-title">{{$item->title}}</li>
                        @foreach($item->subItems as $subItem)
                            @if($user->perfil <= $subItem->permissions)
                                <li class="menu-item-has-children dropdown">
                                    <a href="{{$subItem->target()}}" class="dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true"
                                       aria-expanded="false"> <i class="menu-icon {{$subItem->icon}}"></i>{{$subItem->title}}
                                    </a>
                                    @if($subItem->subItems->count())
                                        <ul class="sub-menu children dropdown-menu">
                                            @foreach($subItem->subItems as $sub)
                                                <li>
                                                    <i class="{{$sub->icon }}"></i>
                                                    <a href="{{$sub->target()}}">{{$sub->title}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @else
                        <li class="">
                            <a href="{{$item->target()}}"><i class="menu-icon {{$item->icon }}"></i>{{$item->title}}</a>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
    </div>
</nav>
