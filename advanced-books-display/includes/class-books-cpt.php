<?php
/**
 * Register Books Custom Post Type and custom meta fields.
 */

class Books_CPT {

    public function __construct() {
        add_action('init', [$this, 'register_books_post_type']);
        add_action('add_meta_boxes', [$this, 'add_books_meta_boxes']);
        add_action('save_post', [$this, 'save_books_meta'], 10, 2);
    }

    /**
     * Register 'books' Custom Post Type
     */
    public function register_books_post_type() {
        $labels = [
            'name'               => __('Books', 'advanced-books-display'),
            'singular_name'      => __('Book', 'advanced-books-display'),
            'add_new'            => __('Add New', 'advanced-books-display'),
            'add_new_item'       => __('Add New Book', 'advanced-books-display'),
            'edit_item'          => __('Edit Book', 'advanced-books-display'),
            'new_item'           => __('New Book', 'advanced-books-display'),
            'view_item'          => __('View Book', 'advanced-books-display'),
            'search_items'       => __('Search Books', 'advanced-books-display'),
            'not_found'          => __('No books found', 'advanced-books-display'),
            'not_found_in_trash' => __('No books found in Trash', 'advanced-books-display'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => ['slug' => 'books'],
            'show_in_rest'       => true,
            'supports'           => ['title', 'editor', 'thumbnail'],
            'menu_icon'          => 'dashicons-book-alt',
        ];

        register_post_type('books', $args);
    }

    /**
     * Add meta boxes for Author Name, Price, Publish Date
     */
    public function add_books_meta_boxes() {
        add_meta_box('book_author', 'Author Name', [$this, 'render_author_field'], 'books', 'normal', 'default');
        add_meta_box('book_price', 'Price ($)', [$this, 'render_price_field'], 'books', 'normal', 'default');
        add_meta_box('book_publish_date', 'Publish Date', [$this, 'render_publish_date_field'], 'books', 'normal', 'default');
    }

    public function render_author_field($post) {
        $value = get_post_meta($post->ID, '_book_author', true);
        echo '<input type="text" name="book_author" value="' . esc_attr($value) . '" class="widefat" />';
    }

    public function render_price_field($post) {
        $value = get_post_meta($post->ID, '_book_price', true);
        echo '<input type="number" name="book_price" value="' . esc_attr($value) . '" class="widefat" step="0.01" />';
    }

    public function render_publish_date_field($post) {
        $value = get_post_meta($post->ID, '_book_publish_date', true);
        echo '<input type="date" name="book_publish_date" value="' . esc_attr($value) . '" class="widefat" />';
    }

    /**
     * Save custom fields
     */
    public function save_books_meta($post_id, $post) {
        if ($post->post_type !== 'books') {
            return;
        }

        if (isset($_POST['book_author'])) {
            update_post_meta($post_id, '_book_author', sanitize_text_field($_POST['book_author']));
        }

        if (isset($_POST['book_price'])) {
            update_post_meta($post_id, '_book_price', floatval($_POST['book_price']));
        }

        if (isset($_POST['book_publish_date'])) {
            update_post_meta($post_id, '_book_publish_date', sanitize_text_field($_POST['book_publish_date']));
        }
    }
}
