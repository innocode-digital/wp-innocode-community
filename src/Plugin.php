<?php

namespace Innocode\Community;

/**
 * Class Plugin
 * @package Innocode\Community
 */
final class Plugin
{
    /**
     * @var API
     */
    private $api;

    /**
     * Plugin constructor.
     * @param string $instance_url
     * @param string $consumer_token
     */
    public function __construct( string $instance_url, string $consumer_token )
    {
        $this->api = new API( $instance_url, $consumer_token );

    }

    public function run()
    {

    }

    /**
     * Returns API object
     * @return API
     */
    public function get_api() : API
    {
        return $this->api;
    }
}
