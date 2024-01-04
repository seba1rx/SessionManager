<?php declare(strict_types=1);

namespace Seba1rx;

class MySessionAdmin extends SessionAdmin{

    public function __construct(array $conf = []){

        $this->sessionName = "SuperDuperSessionName";

        if(isset($conf["sessionLifetime"])){
            $this->sessionLifetime = $conf["sessionLifetime"];
        }

        if(isset($conf["allowedURLs"])){
            foreach($conf["allowedURLs"] as $page){
                $this->allowedUrls[] = $page;
            }
        }

        if(isset($conf["keys"])){
            foreach($conf["keys"] as $key => $value){
                $this->keys[$key] = $value;
            }
        }
    }
}