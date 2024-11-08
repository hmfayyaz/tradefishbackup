<?php

return [
    'Elements' => [
        'general' => [
            'dependency' => [
                'js' => [
                    [
                        'name' => 'general',
                        'src' => 'assets/js/general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'iqonic-general',
                        'src' => 'assets/css/general.css'
                    ],
                ],

            ]
        ],

        /* Accordion */
        'iqonic_accordion' => [
            'class' => 'Iqonic\Elementor\Elements\Accordion\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'accordions',
                        'src' => 'assets/js/accordions.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'accordion',
                        'src' => 'assets/css/accordion.css'
                    ]
                ],
            ]
        ],
    
        /* Button */
        'iq_button' => [
            'class' => 'Iqonic\Elementor\Elements\Button\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'button',
                        'src' => 'assets/css/button.css'
                    ]
                ],
            ]
        ],

        /* Marquee Text */
        'iqonic_marquee_text' => [
            'class' => 'Iqonic\Elementor\Elements\Marquee_Text\Widget',
            'dependency' => [                
                'css' => [
                    [
                        'name' => 'marquee-text',
                        'src' => 'assets/css/marquee_text.css'
                    ]
                ],
            ]
        ],

        /* Image Carousel */
        'iqonic_image_carousel' => [
            'class' => 'Iqonic\Elementor\Elements\Image_Carousel\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'swiper-min',
                        'src' => 'assets/js/swiper.min.js'
                    ],
                    [
                        'name' => 'swiper-general',
                        'src' => 'assets/js/swiper-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'swiper-bundle',
                        'src' => 'assets/css/swiper-bundle.min.css'
                    ],
                    [
                        'name' => 'image-carousel',
                        'src' => 'assets/css/image-carousel.css'
                    ]
                ],
            ]
        ],

        /* Tilt Image Effect */
        'iqonic_image' => [
            'class' => 'Iqonic\Elementor\Elements\Image\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'tilt',
                        'src' => 'assets/js/tilt.js'
                    ],
                ],
                'css' => [
                    [
                        'name' => 'iqonic-image',
                        'src' => 'assets/css/image.css'
                    ]
                ],
            ]
        ],

        /* Client */
        'Client' => [
            'class' => 'Iqonic\Elementor\Elements\Client\Widget',
            'dependency' => [
                'js' => [ 
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ],
                    [
                        'name' => 'client',
                        'src' => 'assets/css/client.css'
                    ]
                ],
            ]
        ],
        
        /* Counter */
        'iqonic_counter' => [
            'class' => 'Iqonic\Elementor\Elements\Counter\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'jquery.countTo',
                        'src' => 'assets/js/jquery.countTo.js'
                    ],
                    [
                        'name' => 'counter',
                        'src' => 'assets/js/counter.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'counter',
                        'src' => 'assets/css/counter.css'
                    ]
                ],
            ]
        ],

        /* Divider */
        'iq_divider' => [
            'class' => 'Iqonic\Elementor\Elements\Divider\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'divider',
                        'src' => 'assets/css/divider.css'
                    ]
                ],
            ]
        ],

        /* Fancy Box */
        'iqonic_fancybox' => [
            'class' => 'Iqonic\Elementor\Elements\FancyBox\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'fancybox',
                        'src' => 'assets/css/fancybox.css'
                    ]
                ],
            ]
        ],

        /* Icon Box */
        'iqonic_icon_box' => [
            'class' => 'Iqonic\Elementor\Elements\IconBox\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'iconbox',
                        'src' => 'assets/css/iconbox.css'
                    ]
                ],
            ]
        ],

        /* Vertcile Timeline */
        'iqonic_vertical_time_line' => [
            'class' => 'Iqonic\Elementor\Elements\VerticalTimeline\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'timeline',
                        'src' => 'assets/css/verticaltimeline.css'
                    ]
                ]
                
            ]
        ],

        /* Testimonial */
        'iq_testimonial' => [
            'class' => 'Iqonic\Elementor\Elements\Testimonial\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ],
                    [
                        'name' => 'testimonial',
                        'src' => 'assets/css/testimonial.css'
                    ]
                ],
            ]
        ],

        /* Team */
        'team' => [
            'class' => 'Iqonic\Elementor\Elements\Team\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ],
                    [
                        'name' => 'team',
                        'src' => 'assets/css/team.css'
                    ]
                ],
            ]
        ],

        /* Progress Bar */
        'iqonic_progressbar' => [
            'class' => 'Iqonic\Elementor\Elements\Progress\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'appear',
                        'src' => 'assets/js/appear.js'
                    ],
                    [
                        'name' => 'progress',
                        'src' => 'assets/js/progress.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'progress',
                        'src' => 'assets/css/progress.css'
                    ]
                ],
            ]
        ],

        /* Title */
        'section_title' => [
            'class' => 'Iqonic\Elementor\Elements\Title\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'Title',
                        'src' => 'assets/css/title.css'
                    ]
                ],
            ]
        ],

        /* Title Slider */
        'Iq_Slider' => [
            'class' => 'Iqonic\Elementor\Elements\TitleSlider\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ]
                ],
            ]
        ],

        /* Count Downt */
        'iqonic_count_down' => [
            'class' => 'Iqonic\Elementor\Elements\CountDown\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'jQuery-countdownTimer-min',
                        'src' => 'assets/js/jQuery.countdownTimer.min.js'
                    ],
                    [
                        'name' => 'countdown',
                        'src' => 'assets/js/countdown.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'countdown',
                        'src' => 'assets/css/countdown.css'
                    ]
                ],
            ]
        ],

        /* Lists */
        'iqonic_lists' => [
            'class' => 'Iqonic\Elementor\Elements\Lists\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'list',
                        'src' => 'assets/css/list.css'
                    ]
                ],
            ]
        ],

        /* Fancy Box List */
        'iqonic_fancybox_list' => [
            'class' => 'Iqonic\Elementor\Elements\FancyBoxList\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'fancyboxlist',
                        'src' => 'assets/css/fancyboxlist.css'
                    ]
                ],
            ]
        ],

        /* Feature Circle */
        'Iq_Feature_Circle' => [
            'class' => 'Iqonic\Elementor\Elements\FeatureCircle\Widget',
            'dependency' => [
                'css' => [
                    [
                    
                        'name' => 'feature-circle',
                        'src' => 'assets/css/feature-circle.css'
                    ]
                ],
            ]
        ],

        /* Horizontal Time */
        'iqonic_horizontal_time_line' => [
            'class' => 'Iqonic\Elementor\Elements\HorizontalTime\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'horizontal-timeline',
                        'src' => 'assets/css/timeline.css'
                    ]
                ],
                'js' => [
                    [
                        'name' => 'horizonta-ltimeline-min',
                        'src' => 'assets/js/timeline.min.js'
                    ],
                    [
                        'name' => 'timeline-custom',
                        'src' => 'assets/js/timeline-custom.js'
                    ]
                ],
                
            ]
        ],

        /* Map chart */
        'iqonic_map_chart' => [
            'class' => 'Iqonic\Elementor\Elements\MapChart\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'amcharts-core',
                        'src' => 'assets/js/amcharts-core.js'
                    ],
                    [
                        'name' => 'amcharts-maps',
                        'src' => 'assets/js/amcharts-maps.js'
                    ],
                    [
                        'name' => 'amcharts-worldLow',
                        'src' => 'assets/js/amcharts-worldLow.js'
                    ],
                    [
                        'name' => 'amcharts-animated',
                        'src' => 'assets/js/amcharts-animated.js'
                    ],
                    [
                        'name' => 'custom-map',
                        'src' => 'assets/js/custom-map.js'
                    ]
                ],
                'css' => [
                    [
                            'name' => 'map',
                            'src' => 'assets/css/map.css'
                    ]
                ],
            ]
        ],

        /* price */
        'iqonic_price' => [
            'class' => 'Iqonic\Elementor\Elements\Price\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'price',
                        'src' => 'assets/css/price.css'
                    ]
                ],
            ]
        ],

        /* Process Step */
        'iqonic_process_steps' => [
            'class' => 'Iqonic\Elementor\Elements\ProcessStep\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'process-step',
                        'src' => 'assets/css/process-step.css'
                    ]
                ],
            ]
        ],

        /* Radial Progress */
        'iq_radial_progress' => [
            'class' => 'Iqonic\Elementor\Elements\RadialProgress\Widget',
            'dependency' => [
                'css' => [
                    [
                    'name' => 'randial-progress',
                    'src' => 'assets/css/randial-progress.css'
                    ],
                    [
                        'name' => 'Tox-progress',
                        'src' => 'assets/css/tox-progress.css'
                    ],
                ],
                'js' => [
                    [
                        'name' => 'Tox-progress',
                        'src' => 'assets/js/tox-progress.min.js'
                    ],
                    [
                        'name' => 'Radial',
                        'src' => 'assets/js/radial-progress.js'
                    ]
                ],
            ]
        ],

        /* Block Quote */
        'Iqonic Blockquote' => [
            'class' => 'Iqonic\Elementor\Elements\BlockQuote\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'blockquote',
                        'src'  => 'assets/css/blockquote.css'
                    ]
                ],
            ]
        ],


        /********** Iqonic layout Header **********/

        //Navigation
            'iqonic_navigation' => [
            'class' => 'Iqonic\Elementor\Elements\Navigation\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'menu',
                        'src' => 'assets/js/menu.js'
                    ],
                ],
                'css' => [
                    [
                        'name' => 'layout-menu',
                        'src' => 'assets/css/menu.css'
                    ],
                ],
            ]
        ],

        // Footer Navigation
        'iqonic_footer_navigation' => [
            'class' => 'Iqonic\Elementor\Elements\FooterNavigation\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'footer-menu',
                        'src' => 'assets/css/footer-menu.css'
                    ]
                ],
            ]
        ],

        /* Social Icons */
        'iqonic_social_icons' => [
            'class' => 'Iqonic\Elementor\Elements\Social_Icons\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'socials-icon',
                        'src' => 'assets/css/social-icons.css'
                    ]
                ],
            ]
        ],

        // Search
        'iqonic_search' => [
            'class' => 'Iqonic\Elementor\Elements\Search\Widget',
            'dependency' => [
                'css' => [
                    [
                        'name' => 'search',
                        'src' => 'assets/css/search-main.css'
                    ]
                ],
                'js' => [
                    [
                        'name' => 'search-custom',
                        'src' => 'assets/js/search-custom.js'
                    ],
                ],
            ]
        ],

        // imagebox
        'iqonic_imageBox' => [
            'class' => 'Iqonic\Elementor\Elements\ImageBox\Widget',
            'dependency' => [
                'js' => [
                    [
                        'name' => 'owl-carousel',
                        'src' => 'assets/js/owl.carousel.min.js'
                    ],
                    [
                        'name' => 'Owl-general',
                        'src' => 'assets/js/owl-general.js'
                    ]
                ],
                'css' => [
                    [
                        'name' => 'Owl-Carousel',
                        'src'  => 'assets/css/owl.carousel.min.css'
                    ],
                    [
                        'name' => 'imagebox',
                        'src' => 'assets/css/imagebox.css'
                    ]
                ],
            ]
        ],

    ]
];
