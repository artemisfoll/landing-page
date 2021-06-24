<?php

function loadModel($modelName){
    require_once (MODEL_PATH . "/{$modelName}.php");
}

function loadView($viewName, $params = array()){ //login viewer to ADM
    if (count($params) > 0){
        foreach ($params as $key => $value){
            if (strlen($key) > 0){
                ${$key} = $value;
            }
        }
    }
    require_once (VIEW_PATH . "/{$viewName}.php");
}

function loadHomeView($viewName, $params = array()){ //starter viewer landing page
    if (count($params) > 0){
        foreach ($params as $key => $value){
            if (strlen($key) > 0){
                ${$key} = $value;
            }
        }
    }

    require_once (TEMPLATE_PATH . "/header.php");
    require_once (TEMPLATE_PATH . "/menu-topo.php");
    require_once (VIEW_PATH . "/{$viewName}.php");
    require_once (TEMPLATE_PATH . "/footer.php");

}

function loadTemplateView($viewName, $params = array()){ // ADM viewer
    if (count($params) > 0){
        foreach ($params as $key => $value){
            if (strlen($key) > 0){
                ${$key} = $value;
            }
        }
    }

    $user = $_SESSION['user'];

    require_once (TEMPLATE_PATH . "/header.php");
    require_once (TEMPLATE_PATH . "/left.php");
    require_once (VIEW_PATH . "/{$viewName}.php");
    require_once (TEMPLATE_PATH . "/footer.php");
}

function renderTitle($title, $subTitle, $icon = null){
    require_once (TEMPLATE_PATH . "/title.php");
}

function portfolioTitle($title = "Projeto", $subTitle = "Comentario"){
    require_once (TEMPLATE_PATH . "/portfolio.php");
}