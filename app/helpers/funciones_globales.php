<?php
function mostrar_alerta_mensaje($tipoAlerta = '', $descripcion = '', $titulo = '')
{
    return '
        toastr.options = {
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr["' . $tipoAlerta . '"]("' . $descripcion . '", "' . $titulo . '");
    ';
}



function mostrar_breadcrumb($title = '', $breadcrumb = array())
{
    $html = '';
    $html .= '
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>' . $title . '</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./dashboard.php">Inicio</a></li>';
    if (sizeof($breadcrumb) > 0) {
        foreach ($breadcrumb as $b) {
            if ($b["href"] != "#") {
                $html .= '<li class="breadcrumb-item"><a href="' . $b["href"] . '">' . $b["tarea"] . '</a></li>';
            } else {
                $html .= '<li class="breadcrumb-item active">' . $b["tarea"] . '</li>';
            }
        }//end 
    }//end 
    $html .= '</ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
        ';
    return $html;
}//

function mostrar_breadcrumb_art($title = '', $breadcrumb = array())
{
    $html = '';
    $html .= '
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>' . $title . '</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./dashboard_artista.php">Inicio</a></li>';
    if (sizeof($breadcrumb) > 0) {
        foreach ($breadcrumb as $b) {
            if ($b["href"] != "#") {
                $html .= '<li class="breadcrumb-item"><a href="' . $b["href"] . '">' . $b["tarea"] . '</a></li>';
            } else {
                $html .= '<li class="breadcrumb-item active">' . $b["tarea"] . '</li>';
            }
        }//end 
    }//end 
    $html .= '</ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
        ';
    return $html;
}//