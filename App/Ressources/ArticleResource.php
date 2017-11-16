<?php

namespace App\Ressources;

use App\Entity\Article;
use App\AbstractResource;
use Slim\Http\Request;
use Slim\Http\Response;

class ArticleResource extends AbstractResource {

    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- GET ARTICLE BY ID
    // -------------------------------------------------------------------------
    public function getArticleById(Request $request, Response $response, $args) {
        $article_id = intval($args["article_id"]);
        if ($article_id === 0) {
            $data = null;
        } else {
            $data = $this->getEntityManager()->find('App\Entity\Article', $article_id);
            //var_dump($data);
        }
        if ($data === null) {
            return $response->withStatus(404, "article Not Found");
        } else {
            $response->write(json_encode($data));
        }

        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- CREATE ARTICLE
    // -------------------------------------------------------------------------
    public function createArticle(Request $request, Response $response, $args) {
        $title = $request->getParam("title");
        $content = $request->getParam("content");
        if($title && $content && isset($_SESSION["user"]) && $_SESSION["user"] !== null){
            $article = new Article();
            $article->setTitle($title);
            $article->setContent($content);
            $article->setAuthor_name($_SESSION['user']->getLastName() . " " . $_SESSION['user']->getFirstName());
            $article->setCreate_date(new \DateTime('now'));
            $this->getEntityManager()->persist($article);
            $this->getEntityManager()->flush($article);
        }else{
            return $response->withStatus(400, "Invalid Article");
        }
        return $response;
    }
    
    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- UPDATE ARTICLE
    // -------------------------------------------------------------------------
    public function updateArticle(Request $request, Response $response, $args) {
        $article_id = intval($request->getParam("article_id"));
        $title = $request->getParam("title");
        $content = $request->getParam("content");
        if($article_id > 0 && $title && $content && isset($_SESSION["user"]) && $_SESSION["user"] !== null){
            $article = $this->getEntityManager()->find(Article::class, $article_id);
            if($article instanceof Article){
                $article->setTitle($title);
                $article->setContent($content);
                $article->setLast_editor_name($_SESSION['user']->getLastName() . " " . $_SESSION['user']->getFirstName());
                $article->setLast_edit_date(new \DateTime('now'));
                $this->getEntityManager()->flush($article);
            }else{
                return $response->withStatus(404, "Article Not Found");
            }
            
        }else{
            return $response->withStatus(400, "Invalid Article");
        }
        return $response;
    }

    // -------------------------------------------------------------------------
    // ------------------------------------------------------------------------- DELETE ARTICLE
    // -------------------------------------------------------------------------
    public function deleteArticle(Request $request, Response $response, $args) {
        $article_id = intval($args["article_id"]);
        if($article_id > 0){
            $comment = $this->getEntityManager()->find(Article::class, $article_id);
            if($comment){
                $this->getEntityManager()->remove($comment);
                $this->getEntityManager()->flush();
            }else{
                return $response->withStatus(404, "Article Not Found");
            }
        }else{
            return $response->withStatus(400, "Invalid Article Id");
        }
    }
}
