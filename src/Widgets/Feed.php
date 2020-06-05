<?php

namespace Innocode\Community\Widgets;

use WP_Widget;

/**
 * Class Feed
 * @package Innocode\Community\Widgets
 */
class Feed extends WP_Widget
{
    /**
     * Feed constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'innocode_community_feed',
            __( 'Innocode Community Feed', 'innocode-community' ),
            [
                'classname'   => 'innocode_community_feed',
                'description' => __(
                    'Retrieves and displays feed from Community.',
                    'innocode-community'
                ),
            ]
        );
    }

    /**
     * Displays widget.
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance )
    {
        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters(
                'widget_title',
                $instance['title']
            ) . $args['after_title'];
        }

        printf(
            "<div id=\"%s-widget\" class=\"innocode_community_feed\"></div>
<script>
window.innocodeCommunity = window.innocodeCommunity || {};
window.innocodeCommunity.widgets = window.innocodeCommunity.widgets || {};
window.innocodeCommunity.widgets['%s'] = %s;
</script>",
            esc_attr( $args['widget_id'] ),
            esc_attr( $args['widget_id'] ),
            json_encode( $instance )
        );

        echo $args['after_widget'];
    }

    /**
     * Displays widget form.
     * @param array $instance
     * @return string|void
     */
    public function form( $instance )
    {
        $field_id_title = $this->get_field_id( 'title' );
        $field_id_feed_id = $this->get_field_id( 'id' ); ?>
        <p>
            <label for="<?= esc_attr( $field_id_title ) ?>">
                <?php esc_html_e( 'Title:', 'innocode-community' ) ?>
            </label>
            <input
                type="text"
                id="<?= esc_attr( $field_id_title ) ?>"
                name="<?= esc_attr( $this->get_field_name( 'title' ) ) ?>"
                value="<?= esc_attr( isset( $instance['title'] ) ? $instance['title'] : '' ) ?>"
                class="widefat"
            >
        </p>
        <p>
            <label for="<?= esc_attr( $field_id_feed_id ) ?>">
                <?php esc_html_e( 'Feed:', 'innocode-community' ) ?>
            </label>
            <!-- @TODO: change to 'select' field when API will be able to retrieve the list of Feeds -->
            <input
                type="number"
                id="<?= esc_attr( $field_id_feed_id ) ?>"
                name="<?= esc_attr( $this->get_field_name( 'id' ) ) ?>"
                value="<?= isset( $instance['id'] ) ? (int) $instance['id'] : '' ?>"
                class="widefat"
            >
        </p>
        <?php
    }

    /**
     * Updates widget data.
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance )
    {
        return [
            'title' => isset( $new_instance['title'] )
                ? sanitize_text_field( $new_instance['title'] )
                : '',
            'id'    => isset( $new_instance['id'] )
                ? (int) $new_instance['id']
                : '',
        ];
    }
}
