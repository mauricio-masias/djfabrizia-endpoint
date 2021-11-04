<?php

namespace App\Services;

use App\Helpers\FilterPostMeta as Helper;
use App\Helpers\ApplyFormat;
use App\Models\Contact;
use App\Helpers\Time;

class ContactService
{
    public static function saveForm( $name, $email, $message, $cf7_id ): object
    {
        $cf7_shape_unserialized = [
            'cfdb7_status' => 'unread',
            'your-name' => $name,
            'your-email' => $email,
            'your-message' => $message
        ];

        $contact = new Contact;
        $contact->form_post_id = $cf7_id;
        $contact->form_value = serialize( $cf7_shape_unserialized );
        $contact->form_date = Time::current_time( 'mysql' );
        $contact->save();

        if ( (int)$contact->id > 0 ) {
            $result = self::sendEmailNotification( $name, $email, $message, $cf7_id );

            return (object)[
                'status' => true,
                'result' => $result,
            ];
        } else {
            return (object)[ 'status' => false ];
        }
    }

    public static function showForm( $metadata ): array
    {
        $contact = Helper::filterMetaDataWithKeys( $metadata, '/\bbook_me_/' );

        return [
            'title' => $contact['book_me_title'],
            'content_left' => ApplyFormat::htmlTags( $contact['book_me_left'] ),
            'content_right' => ApplyFormat::htmlTags( $contact['book_me_right'] ),
            'content_success' => ApplyFormat::htmlTags( $contact['book_me_success'] ),
            'status' => true
        ];
    }

    private static function sendEmailNotification( $name, $email, $message, $cf7_id )
    {
        $template = unserialize( Contact::getCf7FormStructure( $cf7_id ) );

        $template['body'] = str_replace( "[your-name]", $name, $template['body'] );
        $template['body'] = str_replace( "[your-email]", $email, $template['body'] );
        $template['body'] = str_replace( "[your-message]", $message, $template['body'] );

        $to = $template['recipient'];
        $subject = $template['subject'];
        $message = $template['body'];
        $headers = 'From: ' . $email . "\r\n" .
            'Reply-To: ' . $email . "\r\n" .
            'Content-Type: text/plain' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        return mail( $to, $subject, $message, $headers );
    }


}
