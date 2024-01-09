<?php declare(strict_types=1);

namespace Seba1rx;

class MySessionAdmin extends SessionAdmin{

    public function __construct(array $conf = []){

        /**
         * if you are going to use a session name,
         * you will need to destroy it by using the name,
         * see exitp.php in the demo
         */
        $this->sessionName = "SuperDuperSessionName";

        if(isset($conf["sessionLifetime"])){
            $this->sessionLifetime = $conf["sessionLifetime"];
        }

        if(isset($conf["allowedURLs"])){
            foreach($conf["allowedURLs"] as $page){
                if(!in_array($page, $this->allowedUrls)){
                    $this->allowedUrls[] = $page;
                }
            }
        }

        if(isset($conf["keys"])){
            foreach($conf["keys"] as $key => $value){
                $this->keys[$key] = $value;
            }
        }
    }
}