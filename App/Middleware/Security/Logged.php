<?php

namespace App\Middleware\Security;

use Slim\Http\Request;
use Slim\Http\Response;

class Logged {
    public function __invoke(Request $request, Response $response, $next) {
        if(isset($_SESSION["user"]) && $_SESSION["user"] !== null){
            $response->write("Logged ");
            $next($request, $response);
        }else{
            $response->write("Not Logged ");
            $response = $response->withStatus(403, "Not Logged");
        }        
        return $response;
    }
}
