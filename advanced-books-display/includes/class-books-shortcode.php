<?php
/**
 * Shortcode handler for displaying books with filters and AJAX pagination.
 */
class Books_Shortcode {

    public function __construct() {
        add_shortcode('advanced_books', [$this, 'render_books_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_filter_books', [$this, 'handle_ajax']);
        add_action('wp_ajax_nopriv_filter_books', [$this, 'handle_ajax']);
    }

    public function enqueue_scripts() {
        wp_enqueue_style('books-style', plugin_dir_url(__FILE__) . '../public/css/advanced-books-display-public.css');

        wp_enqueue_script(
            'books-script',
            plugin_dir_url(__FILE__) . '../public/js/advanced-books-display-public.js',
            ['jquery'],
            null,
            true
        );

        wp_localize_script('books-script', 'BooksAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }

    public function render_books_shortcode($atts) {
        ob_start();

        $letters = range('A', 'Z');
        ?>
        <div id="books-filter">
            <label>Author Name:
                <select id="filter_author">
                    <option value="">All</option>
                    <?php foreach ($letters as $letter): ?>
                        <option value="<?php echo esc_attr($letter); ?>"><?php echo esc_html($letter); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>Price Range:
                <select id="filter_price">
                    <option value="">All</option>
                    <option value="50-100">$50 - $100</option>
                    <option value="100-150">$100 - $150</option>
                    <option value="150-200">$150 - $200</option>
                </select>
            </label>

            <label>Sort By:
                <select id="filter_sort">
                    <option value="desc">Newest</option>
                    <option value="asc">Oldest</option>
                </select>
            </label>
        </div>

        <div id="books-results"><?php $this->get_filtered_books(); ?></div>
        <?php

        return ob_get_clean();
    }

    public function handle_ajax() {
        $this->get_filtered_books();
        wp_die();
    }

    private function get_filtered_books() {
        $author   = isset($_POST['author']) ? sanitize_text_field($_POST['author']) : '';
        $price    = isset($_POST['price']) ? sanitize_text_field($_POST['price']) : '';
        $sort     = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'desc';
        $paged    = isset($_POST['page']) ? intval($_POST['page']) : 1;

        $meta_query = [];

        if ($author) {
            $meta_query[] = [
                'key'     => '_book_author',
                'value'   => '^' . $author,
                'compare' => 'REGEXP',
            ];
        }

        if ($price) {
            list($min, $max) = explode('-', $price);
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
            'paged'          => $paged,
            'meta_query'     => $meta_query,
            'orderby'        => 'meta_value',
            'meta_key'       => '_book_publish_date',
            'order'          => $sort,
        ]);

        if ($query->have_posts()) {
            echo '<div class="books-list">';
            while ($query->have_posts()) {
                $query->the_post();
                $author = get_post_meta(get_the_ID(), '_book_author', true);
                $price = get_post_meta(get_the_ID(), '_book_price', true);
                $publish_date = get_post_meta(get_the_ID(), '_book_publish_date', true);
                ?>
                <div class="book-item">
                    <h3><?php the_title(); ?></h3>
                    <p><strong>Author:</strong> <?php echo esc_html($author); ?></p>
                    <p><strong>Price:</strong> $<?php echo esc_html($price); ?></p>
                    <p><strong>Published:</strong> <?php echo esc_html($publish_date); ?></p>
                </div>
                <?php
            }
            echo '</div>';

            echo '<div class="books-pagination">';
            echo paginate_links([
                'total'   => $query->max_num_pages,
                'current' => $paged,
                'format'  => '#',
                'type'    => 'plain',
            ]);
            echo '</div>';
        } else {
            echo '<p>No books found.</p>';
        }

        wp_reset_postdata();
    }
}
