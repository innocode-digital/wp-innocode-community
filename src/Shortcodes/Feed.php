<?php

namespace Innocode\Community\Shortcodes;

/**
 * Class Feed
 * @package Innocode\Community\Shortcodes
 */
class Feed
{
    const TAG = 'innocode_community_feed';

    /**
     * Instances counter
     * @var int
     */
    protected static $counter = 0;

    /**
     * Invokes as shortcode callback
     * @param array|string $attr
     * @param string       $content
     * @param string       $tag
     * @return string
     */
    public function __invoke( $attr, $content, $tag )
    {
        if ( ! $attr ) {
            return '';
        }

        $attr = shortcode_atts( [
            'id'    => 0,
            'title' => '',
        ], $attr );
        $attr['id'] = (int) $attr['id'];

        if ( ! $attr['id'] ) {
            return '';
        }

        $before = '';
        $after = '';

        if ( $attr['title'] ) {
            $before = "<section class=\"innocode_community_shortcode\"><h4 class=\"innocode_community_shortcode__title\">{$attr['title']}</h4>";
            $after = "</section>";
        }

        $id = 'innocode_community_feed-' . ++static::$counter;

        return sprintf(
            "%s<div id=\"%s-shortcode\" class=\"innocode_community_feed\"></div>
<script>
window.innocodeCommunity = window.innocodeCommunity || {};
window.innocodeCommunity.shortcodes = window.innocodeCommunity.shortcodes || {};
window.innocodeCommunity.shortcodes['%s'] = %s;
</script>%s",
            $before,
            esc_attr( $id ),
            esc_attr( $id ),
            json_encode( $attr ),
            $after
        );
    }
}
