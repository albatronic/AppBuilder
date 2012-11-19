<?php

/**
 * Description of Router
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 27-nov-2011
 *
 */
class Router extends sfYaml {

    protected $fileRouting = "config/routing.yml";
    protected $params;
    protected $route = "default";
    protected $yaml;

    public function __construct(Request $request) {
        $this->yaml = sfYaml::load($this->fileRouting);
        $this->params = $request->getParameters();
        $this->getRoute();
    }

    public function getController() {
        return $this->yaml[$this->route]['module'];
    }

    public function getAction() {
        return $this->yaml[$this->route]['action'];
    }

    public function getRouting() {
        return $this->fileConfig;
    }

    private function getRoute() {
        if (isset($this->yaml[$this->params[1]]))
            $this->route = $this->params[1];
    }

}

?>
