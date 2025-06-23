<?php
/**
 * Register a REST API endpoint for listing books.
 */

class Books_REST_API {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('books/v1', '/list', [
            'methods'  => 'GET',
            'callback' => [$this, 'get_books'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function get_books($request) {
        $author      = sanitize_text_field($request->get_param('author'));
        $price_range = sanitize_text_field($request->get_param('price_range'));
        $sort_by     = sanitize_text_field($request->get_param('sort_by')) ?: 'desc';

        $meta_query = [];

        if ($author) {
            $meta_query[] = [
                'key'     => '_book_author',
                'value'   => '^' . $author,
                'compare' => 'REGEXP',
            ];
        }

        if ($price_range) {
            list($min, $max) = explode('-', $price_range);
            $meta_query[] = [
                'key'     => '_book_price',
                'value'   => [(float) $min, (float) $max],
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
            ];
        }

        $query = new WP_Query([
            'post_type'      => 'books',
            'post_status'    => 'publish',
            'posts_per_page' => 5,
            'meta_query'     => $meta_query,
            'orderby'        => 'meta_value',
            'meta_key'       => '_book_publish_date',
            'order'          => $sort_by,
        ]);

        $books = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $books[] = [
                    'id'           => get_the_ID(),
                    'title'        => get_the_title(),
                    'author'       => get_post_meta(get_the_ID(), '_book_author', true),
                    'price'        => get_post_meta(get_the_ID(), '_book_price', true),
                    'publish_date' => get_post_meta(get_the_ID(), '_book_publish_date', true),
                    'link'         => get_permalink(),
                ];
            }
        }

        wp_reset_postdata();

        return rest_ensure_response($books);
    }
}
