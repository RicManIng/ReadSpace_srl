<header>
    <nav>
        <div class='left'>
            <img src="./resources/img/books-7448036.svg" alt="stemma">
            <ul>
            <?php
                /**
                 * qui devo leggere tutto il navMenu.json e costruire la nav bar
                 */
                if(isset($_GET['selezione'])){
                    $selected = $_GET['selezione'];
                } else {
                    $selected = 1;
                }
                $navMenu = json_decode(file_get_contents('./databases/nav_menu.json'), true);
                foreach ($navMenu as $key => $item) {
                    if($item['type'] == 'nav'){
                        if($selected == $item['id']){
                            echo "<li><a href='{$item['link']}?selezione={$item['id']}' class='{$item['type']}' id='selected'>{$item['nome']}</a></li>";
                        } else {
                            echo "<li><a href='{$item['link']}?selezione={$item['id']}' class='{$item['type']}'>{$item['nome']}</a></li>";
                        }
                    }

                    if($item['type'] == 'nav_personale'){
                        if($UserLogged){
                            if($selected == $item['id']){
                                echo "<li><a href='{$item['link']}?selezione={$item['id']}' class='{$item['type']}' id='selected'>{$item['nome']}</a></li>";
                            } else {
                                echo "<li><a href='{$item['link']}?selezione={$item['id']}' class='{$item['type']}'>{$item['nome']}</a></li>";
                            }
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <div class='right'>
            <ul>
                <?php
                    if(!isset($_GET['stato']) && !$UserLogged){
                        foreach ($navMenu as $key => $item) {
                            if($item['type'] == 'log'){
                                if($item['id'] == 5){
                                    echo "<li><a href='{$item['link']}' class='{$item['type']}' id='signup'>{$item['nome']}</a></li>";
                                } elseif ($item['id'] == 6) {
                                    echo "<li><a href='{$item['link']}' class='{$item['type']}' id='login'>{$item['nome']}</a></li>";
                                }   
                            }
                        }
                    } elseif ($UserLogged && !isset($_GET['stato'])) {
                        echo "<li>Benvenuto nella tua area privata " . $user->get_name() . "</li>";;
                        echo "<li><a href='login.php?stato=logout' class='logout'>Logout</a></li>";
                    }
                ?>
            </ul>
        </div>
    </nav>
</header>