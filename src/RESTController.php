<?php

namespace Innocode\Community;

use WP_Error;
use WP_Http;
use WP_HTTP_Response;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * Class RESTController
 * @package Innocode\Community
 */
class RESTController extends WP_REST_Controller
{
    /**
     * REST constructor.
     */
    public function __construct()
    {
        $this->namespace = 'innocode/v1';
        $this->rest_base = 'community';
    }

    /**
     * Adds routes.
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            "/$this->rest_base/feeds/(?P<id>[\d]+)",
            [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [ $this, 'get_feed' ],
                'args'     => [
                    'id' => [
                        'description' => __( 'Unique identifier for the object.' ),
                        'type'        => 'integer',
                    ],
                ],
            ]
        );
    }

    /**
     * Retrieves feed from Community through API.
     * @param WP_REST_Request $request
     * @return WP_HTTP_Response|WP_REST_Response|WP_Error
     */
    public function get_feed( WP_REST_Request $request )
    {
        $feed = innocode_community()->get_feed( $request['id'] );

        if ( is_wp_error( $feed ) ) {
            return new WP_Error(
                'rest_feed_error',
                __(
                    'Could not retrieve response from Community API.',
                    'innocode_community_feed'
                ),
                [ 'status' => WP_Http::INTERNAL_SERVER_ERROR ]
            );
        }

        return rest_ensure_response(
            $this->prepare_feed_for_response( $feed )
        );
    }

    /**
     * Prepares feed for response.
     * @param array $feed
     * @return array
     */
    public function prepare_feed_for_response( array $feed )
    {
        // Remove private data
        unset( $feed['feed']['consumer_token'] );

        return $feed;
    }
}
