<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get( '/', function () use ( $router ) {
    return redirect('https://djfabrizia.com');
} );


$router->group( [ 'prefix' => 'api/v1/' ], function () use ( $router ) {
    $router->get( 'nav/{option}', 'Nav\NavController@getNavById' );
    $router->get( 'homepage/{page}', 'Homepage\HomepageController@getPage' );
    $router->get( 'mixes/{page}', 'Mixes\MixesController@getPage' );
    $router->get( 'releases/{page}', 'Releases\ReleasesController@getPage' );
    $router->get( 'playlists/{page}', 'Playlists\PlaylistsController@getPage' );
    $router->get( 'modal/{option}', 'Modal\ModalController@getModal' );
    $router->get( 'more/{section}/{pages}', 'More\MoreController@getMore' );
    $router->get( 'video/{page}', 'Videos\VideoController@getPage' );
    $router->get( 'social/{page}', 'Social\SocialController@getPage' );
    $router->get( 'bio/{page}', 'Bio\BioController@getPage' );
    $router->get( 'gallery/{source}', 'Gallery\GalleryController@getPage' );
    $router->get( 'contact/{page}', 'Contact\ContactController@showForm' );
} );

$router->group( [ 'middleware' => 'auth' ], function () use ( $router ) {
    $router->post( 'api/v1/booking/', 'Contact\ContactController@receiveForm' );
} );
