<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return redirect(env('APP_SOURCE'));
});

$router->group( [ 'prefix' => 'api/v1/' ], function () use ( $router ) {
    $router->get( 'bio/{page}', 'Bio\BioController@getPage' );
    $router->get( 'contact/{page}', 'Contact\ContactController@showForm' );
    $router->get( 'gallery/{source}', 'Gallery\GalleryController@getPage' );
    $router->get( 'homepage/{page}', 'Homepage\HomepageController@getPage' );
    $router->get( 'mixes/{page}', 'Mixes\MixesController@getPage' );
    $router->get( 'modal/{option}', 'Modal\ModalController@getModal' );
    $router->get( 'more/{section}/{pages}', 'More\MoreController@getMore' );
    $router->get( 'nav/{option}', 'Nav\NavController@getNavById' );
    $router->get( 'linktree/{page}', 'Standalone\LinkTreeController@getPage' );
    $router->get( 'playlists/{page}', 'Playlists\PlaylistsController@getPage' );
    $router->get( 'releases/{page}', 'Releases\ReleasesController@getPage' );
    $router->get( 'social/{page}', 'Social\SocialController@getPage' );
    $router->get( 'video/{page}', 'Videos\VideoController@getPage' );
    $router->get( 'epk/{page}', 'Epk\EpkController@getPage' );
} );

$router->group( [ 'middleware' => 'auth' ], function () use ( $router ) {
    $router->post( 'api/v1/booking/', 'Contact\ContactController@receiveForm' );
} );
