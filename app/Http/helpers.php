<?php
    /**
     * Para cargar este helpes vamos a composer.json y en autoload: { "files":["app/Http/helpers.php"]} y luegop en consola
     * composer dumpautoload -o
     * @param $name
     * @return string
     */
    function setActiveRoute($name) {
        return request()->routeIs($name) ? 'active' : '';
    }

?>
