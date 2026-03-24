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

