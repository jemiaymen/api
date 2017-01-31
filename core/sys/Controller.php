<?php

class Controller {

    protected $loader;

    public function __construct(){
        $this->loader = new Loader();
    }
}