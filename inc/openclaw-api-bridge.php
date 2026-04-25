<?php
/**
 * OpenClaw Agent Fleet API Bridge
 * Allows autonomous agents to interact directly with WordPress, bypassing N8N.
 */

if (!defined('ABSPATH')) {
    exit;
}

class OpenClaw_API_Bridge {

    // Hardcoded Secure Token for OpenClaw Fleet
    private $auth_token = 'OC_BULLMIGHT_SECURE_9942_XX';

    public function __construct() {
        add_action('rest_api_init', array($this, 'register_endpoints'));
    }

    public function register_endpoints() {
        register_rest_route('openclaw/v1', '/publish', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_publish'),
            'permission_callback' => array($this, 'verify_token')
        ));

        register_rest_route('openclaw/v1', '/telemetry', array(
            'methods' => 'GET',
            'callback' => array($this, 'handle_telemetry'),
            'permission_callback' => array($this, 'verify_token')
        ));
    }

    public function verify_token($request) {
        $header_token = $request->get_header('x-openclaw-token');
        if ($header_token === $this->auth_token) {
            return true;
        }
        return new WP_Error('rest_forbidden', esc_html__('OpenClaw Authentication Failed.', 'openclaw'), array('status' => 401));
    }

    public function handle_publish($request) {
        $params = $request->get_json_params();
        
        $post_title = sanitize_text_field($params['title'] ?? '');
        $post_content = wp_kses_post($params['content'] ?? '');
        $post_type = sanitize_text_field($params['post_type'] ?? 'post');
        $post_status = sanitize_text_field($params['status'] ?? 'publish');

        if (empty($post_title) || empty($post_content)) {
            return new WP_REST_Response(['error' => 'Title and Content are required.'], 400);
        }

        $post_data = array(
            'post_title'    => $post_title,
            'post_content'  => $post_content,
            'post_status'   => $post_status,
            'post_type'     => $post_type,
            'post_author'   => 1 
        );

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            return new WP_REST_Response(['error' => $post_id->get_error_message()], 500);
        }

        if (!empty($params['image_url'])) {
            $this->attach_remote_image($post_id, $params['image_url']);
        }

        return new WP_REST_Response([
            'success' => true,
            'post_id' => $post_id,
            'url' => get_permalink($post_id)
        ], 200);
    }

    public function handle_telemetry($request) {
        $stats = array(
            'total_posts' => wp_count_posts('post')->publish,
            'total_pages' => wp_count_posts('page')->publish,
            'wp_version' => get_bloginfo('version'),
            'theme_name' => wp_get_theme()->get('Name')
        );
        return new WP_REST_Response($stats, 200);
    }

    private function attach_remote_image($post_id, $image_url) {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        $tmp = download_url($image_url);
        if (is_wp_error($tmp)) return;

        $file_array = array(
            'name' => basename($image_url),
            'tmp_name' => $tmp
        );

        $id = media_handle_sideload($file_array, $post_id);
        if (!is_wp_error($id)) {
            set_post_thumbnail($post_id, $id);
        } else {
            @unlink($tmp);
        }
    }
}

new OpenClaw_API_Bridge();
