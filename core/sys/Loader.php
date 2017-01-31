<?php

class Loader{

    public function library($lib){
        require_once LIB_PATH . "$lib.php";
    }

    public function helper($helper){
        require_once HELPER_PATH . "$helper.php";
    }

}