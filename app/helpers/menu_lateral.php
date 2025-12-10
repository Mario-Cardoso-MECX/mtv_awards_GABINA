<?php
function configuracion_menu($pagina = '')
{
    $menu = array();
    $menu_item = array();
    $sub_menu_item = array();

    //Opcion Dashboard
    $menu_item['is_active'] = (($pagina == 'DASHBOARD') ? true : false);
    $menu_item['href'] = './dashboard.php';
    $menu_item['icon'] = 'fas fa-circle';
    $menu_item['text'] = 'Dashboard';
    $menu_item['submenu'] = array();
    $menu['dashboard'] = $menu_item;

    //Opcion Usuarios
    $menu_item['is_active'] = (($pagina == 'USUARIOS') ? true : false);
    $menu_item['href'] = './usuarios.php';
    $menu_item['icon'] = 'fas fa-user';
    $menu_item['text'] = 'Usuarios';
    $menu_item['submenu'] = array();
    $menu['usuarios'] = $menu_item;

    //Opcion Artistas
    $menu_item['is_active'] = (($pagina == 'ARTISTAS') ? true : false);
    $menu_item['href'] = './artistas.php';
    $menu_item['icon'] = 'fas fa-compact-disc';
    $menu_item['text'] = 'Artistas';
    $menu_item['submenu'] = array();
    $menu['artistas'] = $menu_item;

    // Opción Géneros
    $menu_item['is_active'] = (($pagina == 'GENEROS') ? true : false);
    $menu_item['href'] = './generos.php';
    $menu_item['icon'] = 'fas fa-headphones'; // Usa un ícono apropiado
    $menu_item['text'] = 'Géneros';
    $menu_item['submenu'] = array();
    $menu['Generos'] = $menu_item;

    // //Opcion MultiLevel
    // $menu_item['is_active'] = ($pagina == 'OPCIONPRINCIPAL') ? true : false ;
    // $menu_item['href'] = '#';
    // $menu_item['icon'] = 'fas fa-circle';
    // $menu_item['text'] = 'Level 1';
    // $menu_item['submenu'] = array();

    //     //Subopcion Menu
    //     $sub_menu_item = array();
    //     $sub_menu_item['is_active'] = ($pagina == '') ? true : false ;
    //     $sub_menu_item['href'] = '';
    //     $sub_menu_item['icon'] = 'far fa-circle';
    //     $sub_menu_item['text'] = 'Level 1-1';
    //     $menu_item['submenu']["level1_1"] = $sub_menu_item;

    //     //Subopcion Menu
    //     $sub_menu_item = array();
    //     $sub_menu_item['is_active'] = ($pagina == '') ? true : false ;
    //     $sub_menu_item['href'] = '';
    //     $sub_menu_item['icon'] = 'far fa-circle';
    //     $sub_menu_item['text'] = 'Level 1-2';
    //     $menu_item['submenu']["level1_2"] = $sub_menu_item;

    // $menu['level1'] = $menu_item;

    return $menu;
}//end

function mostrar_menu_lateral($pagina = '')
{

    $menu = configuracion_menu($pagina);
    // print("<pre>".print_r($menu, true)."</pre>");
    $html = ' <li class="nav-header text-center">==== ADMINISTRADOR ====</li>';
    foreach ($menu as $item) {
        if ($item['href'] != "#") {
            $html .= '
                        <li class="nav-item">
                            <a href="' . $item["href"] . '" class="nav-link ' . ($item["is_active"] ? "active" : "") . '">
                                <i class="' . $item["icon"] . ' nav-icon"></i>
                                <p>' . $item["text"] . '</p>
                            </a>
                        </li>
                    ';
        }//end if href != #
        else {
            if (sizeof($item['submenu']) > 0) {
                $html .= '
                            <li class="nav-item ' . ($item["is_active"] ? "menu-is-opening menu-open" : "") . ' ">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon ' . $item["icon"] . '"></i>
                                    <p>
                                        ' . $item["text"] . '
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">';
                foreach ($item['submenu'] as $item_submenu) {
                    $html .= '
                                            <li class="nav-item">
                                                <a href="' . $item_submenu["href"] . '" class="nav-link ' . ($item_submenu["is_active"] ? "active" : "") . '">
                                                    <i class="' . $item_submenu["icon"] . ' nav-icon"></i>
                                                    <p>' . $item_submenu["text"] . '</p>
                                                </a>
                                            </li>
                                        ';
                }//end foreach
                $html .= '</ul>
                            </li>
                        ';
            }//end 
        }// end else
    }//end foreach
    return $html;
}//end 