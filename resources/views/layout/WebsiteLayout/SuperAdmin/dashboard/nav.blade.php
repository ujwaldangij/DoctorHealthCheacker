<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            @php
                $activeClass1 = (url()->current() == route('dashboard')) ? 'active' : '';
            @endphp
            <li class="{{ $activeClass1 }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-home"></i>
                    <span class="nav-label">Home</span>
                </a>
            </li>
            @php
                if (count($menu) > 0) {
                    foreach ($menu as $menuEntry) {
                        $activeClass = '';
                        if (url()->current() == asset($menuEntry['url'])) {
                            $activeClass = 'active';
                        }
                        echo "<li class='" . $activeClass . "'>
                            <a href='" . asset($menuEntry['url']) . "'>
                                <i class='fa " . $menuEntry['icon'] . "'></i>
                                <span class='nav-label'>" . $menuEntry['name'] . "</span>";

                        if (collect($sub_menu)->where('menu_id', $menuEntry['id'])->isNotEmpty()) {
                            echo "<span class='fa arrow'></span>";
                        }

                        echo "</a>";

                        if (count($sub_menu) > 0) {
                            if (collect($sub_menu)->where('menu_id', $menuEntry['id'])->isNotEmpty()) {
                            echo "<ul class='nav nav-second-level collapse'>";
                            }
                            foreach ($sub_menu as $subMenuEntry) {
                                if ($menuEntry['id'] === $subMenuEntry['menu_id']) {
                                    echo "<li><a href='" . $subMenuEntry['url'] . "'>" . $subMenuEntry['submenusname'] . "</a></li>";
                                }
                            }
                            if (collect($sub_menu)->where('menu_id', $menuEntry['id'])->isNotEmpty()) {
                                echo "</ul>";
                            }

                        }

                        echo "</li>";
                    }
                }
            @endphp
        </ul>
    </div>
</nav>
