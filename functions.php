<?php
/**
 * Functions and definitions for Bullmight Mission Control
 */

function bullmight_enqueue_scripts() {
    // Tailwind CSS via CDN for rapid deployment/testing (Phase 1)
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com', array(), '3.4.1', true);
    
    // Custom tailwind config injection
    wp_add_inline_script('tailwindcss', "
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bullmight: {
                            bg: '#0B0D17',
                            surface: '#1C1E26',
                            cyan: '#00F0FF',
                            green: '#00FFA3',
                            grey: '#8E8E93',
                            amber: '#FFB020'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['Roboto Mono', 'monospace'],
                    }
                }
            }
        }
    ");

    // Lucide Icons
    wp_enqueue_script('lucide', 'https://unpkg.com/lucide@latest', array(), null, true);

    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Roboto+Mono:wght@400;500;700&display=swap', array(), null);

    // Main stylesheet
    wp_enqueue_style('bullmight-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'bullmight_enqueue_scripts');

// Initialize Lucide icons after load
function bullmight_footer_scripts() {
    echo "<script>
        lucide.createIcons();
        console.log('%c🐂 Welcome to Bullmight. We do fun shit.', 'color: #00F0FF; font-size: 16px; font-weight: bold;');
    </script>";
}
add_action('wp_footer', 'bullmight_footer_scripts');

// IRO Subdomain Custom Router
function bullmight_iro_subdomain_router($template) {
    if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'iro.bullmight.com') !== false) {
        $new_template = locate_template(array('iro-dashboard.php'));
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'bullmight_iro_subdomain_router', 99);


/**
 * WIMPER X-RAY LEAD TRACKER
 */
add_action('wp_head', function() {
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const visitorData = {
            url: window.location.href,
            referrer: document.referrer,
            userAgent: navigator.userAgent,
            screenWidth: window.screen.width,
            language: navigator.language,
            timestamp: new Date().toISOString()
        };
        fetch('/wp-json/xray/v1/capture', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(visitorData)
        }).catch(err => console.error('X-Ray Error:', err));
    });
    </script>
    <?php
});

add_action('rest_api_init', function () {
    register_rest_route('xray/v1', '/capture', array(
        'methods' => 'POST',
        'callback' => 'process_xray_lead',
        'permission_callback' => '__return_true'
    ));
});

function process_xray_lead($request) {
    $params = $request->get_json_params();
    $visitor_ip = $_SERVER['REMOTE_ADDR'];

    $resolved_lead = array(
        'firstName' => '',
        'lastName' => '',
        'email' => '',
        'phone' => '',
        'companyName' => ''
    );

    if (empty($resolved_lead['email']) && empty($resolved_lead['phone'])) {
        return new WP_REST_Response(['status' => 'anonymous_visitor'], 200);
    }

    $ghl_location_id = 'YOUR_GHL_LOCATION_ID';
    $ghl_pit_token = 'YOUR_GHL_PIT_TOKEN';

    $ghl_payload = array(
        'locationId' => $ghl_location_id,
        'firstName' => $resolved_lead['firstName'],
        'lastName' => $resolved_lead['lastName'],
        'email' => $resolved_lead['email'],
        'phone' => $resolved_lead['phone'],
        'companyName' => $resolved_lead['companyName'],
        'tags' => array('xray-lead', 'wimper-program'),
        'source' => $params['url']
    );

    $ghl_response = wp_remote_post('https://services.leadconnectorhq.com/contacts/', array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $ghl_pit_token,
            'Content-Type' => 'application/json',
            'Version' => '2021-07-28'
        ),
        'body' => wp_json_encode($ghl_payload)
    ));

    return new WP_REST_Response(['status' => 'lead_captured_and_pushed'], 200);
}

require_once get_template_directory() . '/inc/openclaw-api-bridge.php';

