<?php

namespace Innocode\Community;

/**
 * Class Plugin
 * @package Innocode\Community
 */
final class Plugin
{
    /**
     * @var string
     */
    private $instance_url;
    /**
     * @var string
     */
    private $consumer_key;

    /**
     * Plugin constructor.
     * @param string $instance_url
     * @param string $consumer_key
     */
    public function __construct( string $instance_url, string $consumer_key )
    {
        $this->instance_url = $instance_url;
        $this->consumer_key = $consumer_key;
    }

    public function run()
    {

    }
}
