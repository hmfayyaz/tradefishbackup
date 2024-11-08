<?php

namespace Elementor;

$this->add_control(
    'sw_loop',
    [
        'label' => __('Loop', 'iqonicn'),
        'type' => Controls_Manager::SELECT,
        'default' => 'true',
        'options' => [
            'true'  => __('True', 'iqonicn'),
            'false' => __('False', 'iqonicn'),
        ],
    ]
);

$this->add_control(
    'want_pagination',
    [
        'label' => __('Show Pagination ?', 'iqonicn'),
        'type' => Controls_Manager::SELECT,
        'default' => 'false',
        'options' => [
            'true'  => __('True', 'iqonicn'),
            'false' => __('False', 'iqonicn'),
        ],
    ]
);

$this->add_control(
    'want_nav',
    [
        'label' => __('Show Navigation ?', 'iqonicn'),
        'type' => Controls_Manager::SELECT,
        'default' => 'false',
        'options' => [
            'true'  => __('True', 'iqonicn'),
            'false' => __('False', 'iqonicn'),
        ],
    ]
);

$this->add_control(
    'show_drug_cursor',
    [
        'label' => __('Drag Cursor ?', 'iqonicn'),
        'type' => Controls_Manager::SELECT,
        'default' => 'true',
        'options' => [
            'true'  => __('True', 'iqonicn'),
            'false' => __('False', 'iqonicn'),
        ],
    ]
);

$this->add_control(
    'sw_slide',
    [
        'label' => __('Slide Per Page', 'iqonicn'),
        'type' => Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 10,
        'step' => 1,
        'default' => 4,
    ]
);



$this->add_control(
    'sw_laptop_no',
    [
        'label' => __('Laptop View', 'iqonicn'),
        'type' => Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 10,
        'step' => 1,
        'default' => 3,
    ]
);

$this->add_control(
    'sw_tab_no',
    [
        'label' => __('Tablet View', 'iqonicn'),
        'type' => Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 10,
        'step' => 1,
        'default' => 2,
    ]
);

$this->add_control(
    'sw_mob_no',
    [
        'label' => __('Mobile View', 'iqonicn'),
        'type' => Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 10,
        'step' => 1,
        'default' => 1,
    ]
);


$this->add_control(
    'sw_autoplay',
    [
        'label' => __('Auto Play Delay', 'iqonicn'),
        'type' => Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 10000,
        'step' => 5,
        'default' => 4000,
    ]
);

$this->add_control(
    'sw_speed',
    [
        'label' => __('Speed', 'iqonicn'),
        'type' => Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 10000,
        'step' => 1,
        'default' => 1000,
    ]
);

$this->add_control(
    'sw_space_slide',
    [
        'label' => __('Space Between Slide', 'iqonicn'),
        'type' => Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 100,
        'step' => 1,
        'default' => 40,
    ]
);

$this->start_controls_tabs(
    'style_swiper_tabs'
);

$this->start_controls_tab(
    'style_swiper_normal_tab',
    [
        'label' => esc_html__('Normal', 'iqonicn'),
        'condition' => [
            'want_nav' => 'true',
        ],
    ]
);

$this->add_control(
    'navigation_normal_color',
    [
        'label' => __('Navigation Icon Color', 'iqonicn'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'color:{{VALUE}};'
        ],
    ]
);

$this->add_control(
    'navigation_normal_border_color',
    [
        'label' => __('Border Color', 'iqonicn'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .iqonic-navigation .swiper-button-prev ,{{WRAPPER}} .iqonic-navigation .swiper-button-next' => 'border-color:{{VALUE}};'
        ],
    ]
);

$this->end_controls_tab();
$this->start_controls_tab(
    'style_swiper_hover_tab',
    [
        'label' => esc_html__('Hover', 'iqonicn'),
        'condition' => [
            'want_nav' => 'true',
        ],
    ]
);

$this->add_control(
    'navigation_hover_color',
    [
        'label' => __('Navigation Icon Color', 'iqonicn'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .swiper-button-prev:hover .text-btn, {{WRAPPER}} .swiper-button-next:hover .text-btn' => 'color:{{VALUE}};'
        ],
    ]
);

$this->add_control(
    'navigation_hover_border_color',
    [
        'label' => __('Border Color', 'iqonicn'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .iqonic-navigation:hover .swiper-button-prev ,{{WRAPPER}} .iqonic-navigation:hover .swiper-button-next' => 'border-color:{{VALUE}};'
        ],
    ]
);

$this->end_controls_tab();
$this->end_controls_tabs();
