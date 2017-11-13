<?php

namespace App\Ressources;

use App\Entity\User;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class UserResource extends AbstractResource{
    
    private $container;
    
    public function __construct($container) {
        $this->container = $container;
    }
    
    public function getUserById(Request $request, Response $response, $args){
        $id = intval($args["id"]);
        if ($id === 0) {
            $data = null;
        } else {
            $data = $this->getEntityManager()->find('App\Entity\User', $id);
        }
        if($data === null){
            $response = $response->withStatus(404, "User Not Found");
        }else{
            $response->write(json_encode($data)); 
        }  

        return $response;
    }
    
    public function getUserByEmail(Request $request, Response $response, $args){
        $email = $args["email"];
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
        if (preg_match($pattern, $email) === 0) {
            $data = null;
        } else {
            $data = $this->getEntityManager()->getRepository('App\Entity\User')->findBy(Array("email" => $email));
        }
        if($data === null || $data == []){
            $response = $response->withStatus(404, "User Not Found");
        }else{
            $response->write(json_encode($data[0])); 
        }  

        return $response;
    }
    
    public function login(Request $request, Response $response, $args){
        $email = $request->getParam("email");
        $password = $request->getParam("password");
        if($email && $password){
            $data = $this->getEntityManager()->getRepository('App\Entity\User')->findBy(Array("email" => $email));
            if($data === null || $data == []){
                $response = $response->withStatus(401, "Wrong Login");
            }else{
                $user = $data[0];
                if($user->getPassword() === $password){
                    $_SESSION["user"] = $user;
                }else{
                    $response = $response->withStatus(401, "Wrong Login");
                }
            }
        }else{
            $response = $response->withStatus(401, "Invalid Request");
        }
        return $response;
    }
    
    public function logout(Request $request, Response $response, $args){
        session_destroy();
        return $response;
    }
}
