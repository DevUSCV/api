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
$app->get("/", App\Ressources\SiteInfoResource::class . ":getSiteInfo");


// ----------------------------------------------------------------------------- SLIDE ROUTES
// -----------------------------------------------------------------------------
$app->get("/slide", App\Ressources\SlideResource::class . ":getSlide");


// ----------------------------------------------------------------------------- USER ROUTES
require './Routes/UserRoute.php';
// ----------------------------------------------------------------------------- ADDRESS ROUTES
require './Routes/AddressRoute.php';
// ----------------------------------------------------------------------------- CITY ROUTES
require './Routes/CityRoute.php';
// ----------------------------------------------------------------------------- ARTICLE ROUTES
require './Routes/ArticleRoute.php';
// ----------------------------------------------------------------------------- ARTICLE COMMENT ROUTES
require './Routes/ArticleCommentRoute.php';
// ----------------------------------------------------------------------------- BLOG ROUTES
require './Routes/BlogRoute.php';
// ----------------------------------------------------------------------------- BLOG POST ROUTES
require './Routes/BlogPostRoute.php';
// ----------------------------------------------------------------------------- BLOG POST COMMENT ROUTES
require './Routes/BlogPostCommentRoute.php';
// ----------------------------------------------------------------------------- PRICE ROUTES
require './Routes/PriceRoute.php';
// ----------------------------------------------------------------------------- PHOTO ROUTES
require './Routes/PhotoRoute.php';
// ----------------------------------------------------------------------------- LOCATION PRICE
require './Routes/LocationPriceRoute.php';
// ----------------------------------------------------------------------------- RESERVATION DAY
require './Routes/ReservationDayRoute.php';




// Run the Application
$app->run();
