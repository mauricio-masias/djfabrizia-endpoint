<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\ContactService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;


class ContactController extends Controller
{
    protected $cf7_id = 986;
    protected $page = 952;

    public function __construct()
    {
        // CF7 Form ID : 986
        // 952 homepage
    }

    public function receiveForm( Request $request )
    {
        $name = strip_tags( addslashes( trim( $request->input( 'name' ) ) ) );
        $email = strip_tags( addslashes( trim( $request->input( 'email' ) ) ) );
        $message = strip_tags( addslashes( trim( $request->input( 'message' ) ) ) );

        if ( $name = '' && $email = '' ) {
            return ErrorService::bookingError( 'Empty fields' );
        }

        $save = ContactService::saveForm( $name, $email, $message, $this->cf7_id );

        return ( $save->status )
            ? response( [ 'status' => true, 'mail' => $save->result ] )
            : ErrorService::bookingError( 'Booking cannot be added' );
    }

    public function showForm( $page )
    {
        if ( (int)$page <= 0 || !Post::pageExist( $page ) ) {
            return ErrorService::verboseError( $page, 'not_found' );
        }

        $metadata = Post::getPostMeta( $page );

        return Cache::remember(
            CONTACT_CACHE_KEY,
            Carbon::now()->addDays( 30 ),
            function () use ( $page, $metadata ) {
                return ( !empty( $metadata ) )
                    ? response( [ ContactService::showForm( $metadata ) ] )
                    : ErrorService::verboseError( $page, 'empty_metadata', 402 );
            }
        );
    }
}


