<?php

namespace Innocode\Community;

use Innocode\Community\Widgets;
use WP_Widget;

/**
 * Class Plugin
 * @package Innocode\Community
 */
final class Plugin
{
    /**
     * API object.
     * @var API
     */
    private $api;
    /**
     * REST controller.
     * @var RESTController
     */
    private $rest_controller;
    /**
     * Widgets collection.
     * @var WP_Widget[]
     */
    private $widgets = [];
    /**
     * Shortcodes collection.
     * @var array
     */
    private $shortcodes = [];

    /**
     * Plugin constructor.
     * @param string $instance_url
     * @param string $consumer_token
     */
    public function __construct( string $instance_url, string $consumer_token )
    {
        $this->api = new API( $instance_url, $consumer_token );
        $this->rest_controller = new RESTController();
        $this->widgets['feed'] = new Widgets\Feed();
        $this->shortcodes['feed'] = new Shortcodes\Feed();
    }

    /**
     * Adds hooks.
     */
    public function run()
    {
        add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );
        add_action( 'widgets_init', [ $this, 'register_widgets' ] );
        add_action( 'init', [ $this, 'register_shortcodes' ] );
    }

    /**
     * Returns API object.
     * @return API
     */
    public function get_api() : API
    {
        return $this->api;
    }

    /**
     * Returns REST controller.
     * @return RESTController
     */
    public function get_rest_controller() : RESTController
    {
        return $this->rest_controller;
    }

    /**
     * Returns widgets collection.
     * @return WP_Widget[]
     */
    public function get_widgets() : array
    {
        return $this->widgets;
    }

    /**
     * Returns shortcodes collection.
     * @return array
     */
    public function get_shortcodes() : array
    {
        return $this->shortcodes;
    }

    /**
     * Adds routes.
     */
    public function register_rest_routes()
    {
        $this->get_rest_controller()->register_routes();
    }

    /**
     * Adds widgets.
     */
    public function register_widgets()
    {
        foreach ( $this->get_widgets() as $widget ) {
            register_widget( $widget );
        }
    }

    /**
     * Adds shortcodes.
     */
    public function register_shortcodes()
    {
        foreach ( $this->get_shortcodes() as $shortcode ) {
            add_shortcode( $shortcode::TAG, $shortcode );
        }
    }
}
