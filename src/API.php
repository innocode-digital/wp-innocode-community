<?php

namespace Innocode\Community;

use WP_Error;

/**
 * Class API
 * @package Innocode\Community
 */
class API
{
    const NAMESPACE = 'api/v2';

    /**
     * Community instance URL.
     * @var string
     */
    private $instance_url;
    /**
     * Community consumer token.
     * @var string
     */
    private $consumer_token;

    /**
     * API constructor.
     * @param string $instance_url
     * @param string $consumer_token
     */
    public function __construct( string $instance_url, string $consumer_token )
    {
        $this->instance_url = rtrim( $instance_url, '/' );
        $this->consumer_token = $consumer_token;
    }

    /**
     * Returns Community instance URL.
     * @return string
     */
    public function get_instance_url() : string
    {
        return $this->instance_url;
    }

    /**
     * Returns Community consumer token.
     * @return string
     */
    public function get_consumer_token() : string
    {
        return $this->consumer_token;
    }

    /**
     * Generates API URL for needed instance with consumer token.
     * @param string $path
     * @param array  $query_args
     * @return string
     */
    public function url( string $path, array $query_args = [] ) : string
    {
        $path = trim( $path, '/' );

        return add_query_arg(
            wp_parse_args( $query_args, [
                'consumer_token' => $this->get_consumer_token(),
            ] ),
            "{$this->get_instance_url()}/" . static::NAMESPACE . "/$path.json"
        );
    }

    /**
     * Performs HTTP request to Community API.
     * @param string $method
     * @param string $path
     * @param array  $query_args
     * @param array  $args
     * @return array|WP_Error
     */
    public function request( string $method, string $path, array $query_args = [], array $args = [] )
    {
        $response = wp_remote_request(
            $this->url( $path, $query_args ),
            wp_parse_args( $args, [
                'method'    => $method,
                'sslverify' => false,
            ] )
        );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        return json_decode( wp_remote_retrieve_body( $response ), true );
    }

    /**
     * Performs HTTP GET request to Community API.
     * @param string $path
     * @param array  $query_args
     * @param array  $args
     * @return array|WP_Error
     */
    public function get( string $path, array $query_args = [], array $args = [] )
    {
        return $this->request( 'GET', $path, $query_args, $args );
    }

    /**
     * Retrieves Community feed.
     * @param int   $id
     * @param array $query_args
     * @param array $args
     * @return array|WP_Error
     */
    public function get_feed( int $id, array $query_args = [], array $args = [] )
    {
        return $this->get( "feeds/$id", $query_args, $args );
    }
}
