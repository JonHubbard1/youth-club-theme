/**
 * Customizer Live Preview
 * 
 * This file adds live preview functionality to the WordPress Customizer,
 * allowing users to see changes in real-time as they adjust settings.
 */

(function($) {
    'use strict';

    // Helper function to update CSS custom properties
    function updateCSSProperty(property, value) {
        document.documentElement.style.setProperty(property, value);
    }

    // Color Controls
    wp.customize('primary_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--primary-color', newval);
        });
    });

    wp.customize('secondary_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--secondary-color', newval);
        });
    });

    wp.customize('accent_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--accent-color', newval);
        });
    });

    wp.customize('heading_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--heading-color', newval);
        });
    });

    wp.customize('body_text_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--body-text-color', newval);
        });
    });

    wp.customize('link_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--link-color', newval);
        });
    });

    wp.customize('header_bg_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--header-bg-color', newval);
        });
    });

    wp.customize('footer_bg_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--footer-bg-color', newval);
            
            // Calculate contrasting text colors
            const contrastColors = calculateContrastColors(newval);
            updateCSSProperty('--footer-text-color', contrastColors.text);
            updateCSSProperty('--footer-heading-color', contrastColors.heading);
            updateCSSProperty('--footer-link-color', contrastColors.link);
            updateCSSProperty('--footer-link-hover-color', contrastColors.linkHover);
            updateCSSProperty('--footer-border-color', contrastColors.border);
        });
    });

    wp.customize('background_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--background-color', '#' + newval);
        });
    });

    // Typography Controls
    wp.customize('heading_font', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--heading-font', newval);
            
            // Load Google Font if needed
            loadGoogleFont(newval);
        });
    });

    wp.customize('body_font', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--body-font', newval);
            
            // Load Google Font if needed
            loadGoogleFont(newval);
        });
    });

    wp.customize('heading_font_size', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--heading-font-size', newval + 'px');
        });
    });

    wp.customize('body_font_size', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--body-font-size', newval + 'px');
        });
    });

    wp.customize('line_height', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--line-height', newval);
        });
    });

    // Logo Controls
    wp.customize('custom_logo_height', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--logo-height', newval + 'px');
        });
    });

    wp.customize('logo_margin_bottom', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--logo-margin-bottom', newval + 'px');
        });
    });

    // Hero Section Controls
    wp.customize('hero_title', function(value) {
        value.bind(function(newval) {
            $('.hero-title').text(newval);
        });
    });

    wp.customize('hero_subtitle', function(value) {
        value.bind(function(newval) {
            $('.hero-subtitle').text(newval);
        });
    });

    wp.customize('hero_primary_text', function(value) {
        value.bind(function(newval) {
            $('.hero-cta .btn-primary').text(newval);
        });
    });

    wp.customize('hero_primary_link', function(value) {
        value.bind(function(newval) {
            $('.hero-cta .btn-primary').attr('href', newval);
        });
    });

    // Statistics Controls
    for (let i = 1; i <= 4; i++) {
        wp.customize('stat_' + i + '_number', function(value) {
            value.bind(function(newval) {
                $('.stat-' + i + ' .stat-number').text(newval);
            });
        });

        wp.customize('stat_' + i + '_label', function(value) {
            value.bind(function(newval) {
                $('.stat-' + i + ' .stat-label').text(newval);
            });
        });
    }

    // Contact Information Controls
    wp.customize('contact_phone', function(value) {
        value.bind(function(newval) {
            $('.contact-phone').text(newval);
            $('.contact-phone').attr('href', 'tel:' + newval.replace(/\s/g, ''));
        });
    });

    wp.customize('contact_email', function(value) {
        value.bind(function(newval) {
            $('.contact-email').text(newval);
            $('.contact-email').attr('href', 'mailto:' + newval);
        });
    });

    wp.customize('contact_address', function(value) {
        value.bind(function(newval) {
            $('.contact-address').text(newval);
        });
    });

    // Social Media Controls
    const socialPlatforms = ['facebook', 'twitter', 'instagram', 'linkedin'];
    socialPlatforms.forEach(function(platform) {
        wp.customize('social_' + platform, function(value) {
            value.bind(function(newval) {
                const $link = $('.social-' + platform);
                if (newval) {
                    $link.attr('href', newval).show();
                } else {
                    $link.hide();
                }
            });
        });
    });

    // Footer Controls
    wp.customize('footer_about_text', function(value) {
        value.bind(function(newval) {
            $('.footer-about-text').text(newval);
        });
    });

    wp.customize('footer_copyright_text', function(value) {
        value.bind(function(newval) {
            $('.footer-copyright').text(newval);
        });
    });

    // Charity and Company Numbers
    wp.customize('charity_number', function(value) {
        value.bind(function(newval) {
            if (newval) {
                if ($('.charity-number').length) {
                    $('.charity-number').text('Registered Charity No: ' + newval);
                } else {
                    // Refresh to show/hide the registration numbers section
                    wp.customize.previewer.refresh();
                }
            } else {
                wp.customize.previewer.refresh();
            }
        });
    });

    wp.customize('company_number', function(value) {
        value.bind(function(newval) {
            if (newval) {
                if ($('.company-number').length) {
                    $('.company-number').text('Company No: ' + newval);
                } else {
                    // Refresh to show/hide the registration numbers section
                    wp.customize.previewer.refresh();
                }
            } else {
                wp.customize.previewer.refresh();
            }
        });
    });

    /**
     * Calculate contrasting colors based on background color
     */
    function calculateContrastColors(backgroundColor) {
        // Remove # if present
        const hex = backgroundColor.replace('#', '');
        
        // Convert to RGB
        const r = parseInt(hex.substr(0, 2), 16);
        const g = parseInt(hex.substr(2, 2), 16);
        const b = parseInt(hex.substr(4, 2), 16);
        
        // Calculate brightness using standard formula
        const brightness = (r * 299 + g * 587 + b * 114) / 1000;
        
        // Determine if background is light or dark
        const isLight = brightness > 128;
        
        return {
            text: isLight ? '#333333' : '#ecf0f1',
            heading: isLight ? '#2c3e50' : '#ffffff',
            link: isLight ? '#666666' : '#bdc3c7',
            linkHover: '#e74c3c', // Always use primary color for hover
            border: isLight ? '#e0e0e0' : '#34495e'
        };
    }

    /**
     * Helper function to load Google Fonts dynamically
     */
    function loadGoogleFont(fontFamily) {
        const googleFonts = {
            'Roboto, sans-serif': 'Roboto:300,400,500,600,700',
            'Open Sans, sans-serif': 'Open+Sans:300,400,500,600,700',
            'Lato, sans-serif': 'Lato:300,400,700',
            'Montserrat, sans-serif': 'Montserrat:300,400,500,600,700',
            'Playfair Display, serif': 'Playfair+Display:400,700',
            'Merriweather, serif': 'Merriweather:300,400,700'
        };

        if (googleFonts[fontFamily]) {
            // Remove existing Google Font link for this font family
            $('link[href*="' + googleFonts[fontFamily].split(':')[0] + '"]').remove();
            
            // Add new Google Font link
            const fontUrl = 'https://fonts.googleapis.com/css2?family=' + googleFonts[fontFamily] + '&display=swap';
            $('head').append('<link rel="stylesheet" type="text/css" href="' + fontUrl + '">');
        }
    }

    /**
     * Handle live logo changes
     */
    wp.customize('custom_logo', function(value) {
        value.bind(function(newval) {
            if (newval) {
                // Logo was added/changed
                wp.customize.previewer.refresh();
            } else {
                // Logo was removed
                $('.custom-logo').remove();
            }
        });
    });

    // ===================================
    // About Section Controls
    // ===================================
    wp.customize('about_title', function(value) {
        value.bind(function(newval) {
            $('#about .section-title').text(newval);
        });
    });

    wp.customize('about_paragraph_1', function(value) {
        value.bind(function(newval) {
            $('#about .about-content p:first-of-type').text(newval);
        });
    });

    wp.customize('about_paragraph_2', function(value) {
        value.bind(function(newval) {
            $('#about .about-content p:nth-of-type(2)').text(newval);
        });
    });

    // About features
    for (let i = 1; i <= 4; i++) {
        wp.customize('about_feature_' + i, function(value) {
            value.bind(function(newval) {
                $('#about .feature-item:nth-child(' + i + ') span:last-child').text(newval);
            });
        });
    }

    wp.customize('about_button_text', function(value) {
        value.bind(function(newval) {
            $('#about .btn-primary').text(newval);
        });
    });

    wp.customize('about_button_link', function(value) {
        value.bind(function(newval) {
            $('#about .btn-primary').attr('href', newval);
        });
    });

    // ===================================
    // Services Section Controls
    // ===================================
    wp.customize('services_title', function(value) {
        value.bind(function(newval) {
            $('#services .section-title').text(newval);
        });
    });

    wp.customize('services_subtitle', function(value) {
        value.bind(function(newval) {
            $('#services .section-subtitle').text(newval);
        });
    });

    // Service controls
    for (let i = 1; i <= 3; i++) {
        wp.customize('service_' + i + '_icon', function(value) {
            value.bind(function(newval) {
                $('#services .card:nth-child(' + i + ') .card-icon span').text(newval);
            });
        });

        wp.customize('service_' + i + '_title', function(value) {
            value.bind(function(newval) {
                $('#services .card:nth-child(' + i + ') .card-title').text(newval);
            });
        });

        wp.customize('service_' + i + '_description', function(value) {
            value.bind(function(newval) {
                $('#services .card:nth-child(' + i + ') .card-content').text(newval);
            });
        });

        wp.customize('service_' + i + '_features', function(value) {
            value.bind(function(newval) {
                let $ul = $('#services .card:nth-child(' + i + ') ul');
                $ul.empty();
                if (newval) {
                    let features = newval.split('\n');
                    features.forEach(function(feature) {
                        if (feature.trim()) {
                            $ul.append('<li>• ' + feature.trim() + '</li>');
                        }
                    });
                }
            });
        });

        wp.customize('service_' + i + '_link', function(value) {
            value.bind(function(newval) {
                $('#services .card:nth-child(' + i + ') .btn-secondary').attr('href', newval);
            });
        });
    }

    // ===================================
    // Testimonials Section Controls
    // ===================================
    wp.customize('testimonials_title', function(value) {
        value.bind(function(newval) {
            $('.testimonial').closest('.content-section').find('.section-title').text(newval);
        });
    });

    wp.customize('testimonials_subtitle', function(value) {
        value.bind(function(newval) {
            $('.testimonial').closest('.content-section').find('.section-subtitle').text(newval);
        });
    });

    // Testimonial controls
    for (let i = 1; i <= 2; i++) {
        wp.customize('testimonial_' + i + '_content', function(value) {
            value.bind(function(newval) {
                $('.testimonial:nth-child(' + i + ') .testimonial-content').text('"' + newval + '"');
            });
        });

        wp.customize('testimonial_' + i + '_author', function(value) {
            value.bind(function(newval) {
                $('.testimonial:nth-child(' + i + ') .testimonial-author').text(newval);
            });
        });

        wp.customize('testimonial_' + i + '_role', function(value) {
            value.bind(function(newval) {
                $('.testimonial:nth-child(' + i + ') .testimonial-role').text(newval);
            });
        });
    }

    // ===================================
    // Funding Partners Section Controls
    // ===================================
    wp.customize('funding_partners_enable', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.funding-partners-section').show();
            } else {
                $('.funding-partners-section').hide();
            }
        });
    });

    wp.customize('funding_partners_title', function(value) {
        value.bind(function(newval) {
            $('.funding-partners-title').text(newval);
        });
    });

    wp.customize('funding_partners_bg_color', function(value) {
        value.bind(function(newval) {
            $('.funding-partners-section').css('background-color', newval);
        });
    });

    // Handle logo visibility toggles
    for (let i = 1; i <= 12; i++) {
        wp.customize('funding_logo_' + i + '_visible', function(value) {
            value.bind(function(newval) {
                // This would require a refresh to properly recalculate the grid
                wp.customize.previewer.refresh();
            });
        });
        
        wp.customize('funding_logo_' + i, function(value) {
            value.bind(function(newval) {
                // Logo changed, refresh to update display
                wp.customize.previewer.refresh();
            });
        });
        
        wp.customize('funding_logo_' + i + '_name', function(value) {
            value.bind(function(newval) {
                // Update alt text and title - refresh for simplicity
                wp.customize.previewer.refresh();
            });
        });
        
        wp.customize('funding_logo_' + i + '_url', function(value) {
            value.bind(function(newval) {
                // Update link - refresh for simplicity
                wp.customize.previewer.refresh();
            });
        });
    }

})(jQuery);