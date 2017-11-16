<?php

require './vendor/autoload.php';

session_start();

use Slim\Http\Request;
use Slim\Http\Response;

// -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------- Create Application
// -----------------------------------------------------------------------------
$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
        ]);
// -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------- Set Middleware
// -----------------------------------------------------------------------------
$app->add(new App\Middleware\ApiCookie());

// -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------- Define container's contents
// -----------------------------------------------------------------------------
$container = $app->getContainer();

// Define Routes
$app->get("/", function(Request $request, Response $response, $args) {
    $response->write("ok");
    return $response;
})->add(new App\Middleware\Security\Logged());

// -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------- USER ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/user", App\Ressources\UserResource::class . ":createUser");
//GET
$app->get("/user/id/{user_id}", App\Ressources\UserResource::class . ":getUserById");
$app->get("/user/email/{email}", App\Ressources\UserResource::class . ":getUserByEmail");
// PUT
$app->put("/user/updatePassword", App\Ressources\UserResource::class . ":updatePassword");
// DELETE
$app->delete("/user/{user_id}", App\Ressources\UserResource::class . ":deleteUser");
// SESSION
$app->post("/user/login", App\Ressources\UserResource::class . ":login");
$app->get("/user/logout", App\Ressources\UserResource::class . ":logout");


// -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------- ARTICLE ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/article", App\Ressources\ArticleResource::class . ":createArticle")->add(new App\Middleware\Security\Logged());
// GET
$app->get("/article/id/{article_id}", App\Ressources\ArticleResource::class . ":getArticleById");
// PUT
$app->put("/article", App\Ressources\ArticleResource::class . ":updateArticle")->add(new App\Middleware\Security\Logged());
// DELETE
$app->delete("/article/{article_id}", App\Ressources\ArticleCommentResource::class . ":deleteArticle");

// -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------- ARTICLE COMMENT ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/article/comment/{article_id}", App\Ressources\ArticleCommentResource::class . ":createArticleComment")->add(new App\Middleware\Security\Logged());
// GET
$app->get("/article/comments/{article_id}", App\Ressources\ArticleCommentResource::class . ":getArticleCommentsByArticleId");
// DELETE
$app->delete("/article/comment/{article_comment_id}", App\Ressources\ArticleCommentResource::class . ":deleteArticleComment");

// -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------- BLOG ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/blog", App\Ressources\BlogResource::class . ":createBlog");
// GET
$app->get("/blog/{blog_name}", App\Ressources\BlogResource::class . ":getBlogByName");
// PUT 
$app->put("/blog", App\Ressources\BlogResource::class . ":updateBlog");
// DELETE
$app->delete("/blog/{blog_id}", App\Ressources\BlogResource::class . ":deleteBlog");

// -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------- BLOG POST ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/blog/post/{blog_id}", App\Ressources\ArticleCommentResource::class . ":createBlogPost")->add(new App\Middleware\Security\Logged());
// GET
$app->get("/blog/post/{blog_post_id}", App\Ressources\BlogPostResource::class . ":getBlogPostById");
// PUT
$app->put("/blog/post", App\Ressources\BlogPostResource::class . ":updateBlogPost")->add(new App\Middleware\Security\Logged());
// DELETE
$app->delete("/blog/post/{blog_post_id}", App\Ressources\BlogPostResource::class . ":deleteBlogPost");

// -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------- BLOG POST COMMENT ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/blog/post/comment/{blog_post_id}", App\Ressources\BlogPostCommentResource::class . ":createBlogPostComment")->add(new App\Middleware\Security\Logged());
// GET
$app->get("/blog/post/comment/{blog_post_id}", App\Ressources\BlogPostCommentResource::class . ":getBlogPostCommentByPostId");
// DELETE
$app->delete("/blog/post/comment/{blog_post_comment_id}", App\Ressources\BlogPostCommentResource::class . ":deleteBlogPostComment");





// Run the Application
$app->run();
