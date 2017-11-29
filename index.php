<?php

require './vendor/autoload.php';

session_start();

// ----------------------------------------------------------------------------- Create Application
// -----------------------------------------------------------------------------
$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
        ]);
// ----------------------------------------------------------------------------- Set Middleware
// -----------------------------------------------------------------------------
$app->add(new App\Middleware\ApiCookie());

// ----------------------------------------------------------------------------- Define container's contents
// -----------------------------------------------------------------------------
$container = $app->getContainer();
$container['upload_directory'] = "/uploads";


// ----------------------------------------------------------------------------- SITE ROUTES
// -----------------------------------------------------------------------------
// GET
$app->get("/", App\Ressources\SiteResource::class . ":getSite");


// ----------------------------------------------------------------------------- SLIDE ROUTES
// -----------------------------------------------------------------------------
$app->get("/slide", App\Ressources\SlideResource::class . ":getSlide");


// ----------------------------------------------------------------------------- USER ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/user", App\Ressources\UserResource::class . ":createUser");
//GET
$app->get("/user/id/{user_id}", App\Ressources\UserResource::class . ":getUserById"); // TODO join to one
$app->get("/user/email/{email}", App\Ressources\UserResource::class . ":getUserByEmail");
// PUT
$app->put("/user/updatePassword", App\Ressources\UserResource::class . ":updatePassword");
// DELETE
$app->delete("/user/{user_id}", App\Ressources\UserResource::class . ":deleteUser");
// SESSION
$app->post("/user/login", App\Ressources\UserResource::class . ":login");
$app->post("/user/logout", App\Ressources\UserResource::class . ":logout");


// ----------------------------------------------------------------------------- ADDRESS ROUTES
// -----------------------------------------------------------------------------
// PUT
$app->put("/user/address", App\Ressources\AddressResource::class . ":updateCurrentUserAddress")
        ->add(new App\Middleware\Security\Logged());
$app->put("/user/{user_id}/address", App\Ressources\AddressResource::class . ":updateUserAddress");


// ----------------------------------------------------------------------------- CITY ROUTES
// -----------------------------------------------------------------------------
// GET
$app->get("/city/{search}", App\Ressources\CityResource::class . ":getCityAutoComplete");


// ----------------------------------------------------------------------------- ARTICLE ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/article", App\Ressources\ArticleResource::class . ":createArticle")
        ->add(new App\Middleware\Security\Logged());
// GET
$app->get("/article/{article}", App\Ressources\ArticleResource::class . ":getArticle");
// PUT
$app->put("/article/{article_id}", App\Ressources\ArticleResource::class . ":updateArticle")
        ->add(new App\Middleware\Security\Logged());
// DELETE
$app->delete("/article/{article_id}", App\Ressources\ArticleCommentResource::class . ":deleteArticle");


// ----------------------------------------------------------------------------- ARTICLE COMMENT ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/article/{article_id}/comment", App\Ressources\ArticleCommentResource::class . ":createArticleComment")
        ->add(new App\Middleware\Security\Logged());
// GET
$app->get("/article/{article_id}/comment", App\Ressources\ArticleCommentResource::class . ":getArticleCommentsByArticleId");
// DELETE
$app->delete("/article/{article_id}/comment/{article_comment_id}", App\Ressources\ArticleCommentResource::class . ":deleteArticleComment");


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


// ----------------------------------------------------------------------------- BLOG POST ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/blog/{blog_name}/post", App\Ressources\ArticleCommentResource::class . ":createBlogPost")
        ->add(new App\Middleware\Security\Logged());
// GET
$app->get("/blog/{blog_name}/post/{blog_post_id}", App\Ressources\BlogPostResource::class . ":getBlogPostById");
// PUT
$app->put("/blog/{blog_name}/post", App\Ressources\BlogPostResource::class . ":updateBlogPost")
        ->add(new App\Middleware\Security\Logged());
// DELETE
$app->delete("/blog/{blog_name}/post/{blog_post_id}", App\Ressources\BlogPostResource::class . ":deleteBlogPost");


// ----------------------------------------------------------------------------- BLOG POST COMMENT ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/blog/{blog_name}/post/{blog_post_id}/comment", App\Ressources\BlogPostCommentResource::class . ":createBlogPostComment")
        ->add(new App\Middleware\Security\Logged());
// GET
$app->get("/blog/{blog_name}/post/{blog_post_id}/comment", App\Ressources\BlogPostCommentResource::class . ":getBlogPostCommentByPostId");
// DELETE
$app->delete("/blog/{blog_name}/post/{blog_post_id}/comment/{blog_post_comment_id}", App\Ressources\BlogPostCommentResource::class . ":deleteBlogPostComment");


// ----------------------------------------------------------------------------- PRICE ROUTES
// -----------------------------------------------------------------------------
// POST

// PUT 

// GET
$app->get("/price/{category}", App\Ressources\PriceResource::class . ":getPriceByCategory");
// DELETE


// ----------------------------------------------------------------------------- PHOTO ROUTES
// -----------------------------------------------------------------------------
// POST
$app->post("/photo", App\Ressources\PhotoResource::class . ":postPhoto");
// PUT 
$app->put("/photo", App\Ressources\PhotoResource::class . ":updatePhoto");
// GET
$app->get("/photo", App\Ressources\PhotoResource::class . ":getPhotos");
// DELETE
$app->delete("/photo/{photo_id}", App\Ressources\PhotoResource::class . ":deletePhoto");




// Run the Application
$app->run();
