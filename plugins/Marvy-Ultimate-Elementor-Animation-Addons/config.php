<?php

return [
    'bg-animation' => [
        'birds_animation' => [
            'class' => '\MarvyElementor\animation\MarvyBirdsAnimation',
            'dependency' => [
                'js'=>[
                    [
                      'name' => 'three',
                      'src' => 'assets/js/lib/three.min.js'
                    ],
                    [
                        'name' => 'vanta-birds',
                        'src' => 'assets/js/lib/vanta.birds.min.js'
                    ],
                    [
                        'name' => 'marvy-birds',
                        'src' => 'assets/js/custom/marvy.birds.min.js'
                    ]
                ],
            ]
        ],
        'cells_animation' => [
          'class' => '\MarvyElementor\animation\MarvyCellsAnimation',
          'dependency' => [
            'js'=>[
              [
                'name' => 'three',
                'src' => 'assets/js/lib/three.min.js'
              ],
              [
                'name' => 'vanta-cells',
                'src' => 'assets/js/lib/vanta.cells.min.js'
              ],
              [
                'name' => 'marvy-cells',
                'src' => 'assets/js/custom/marvy.cells.min.js'
              ]
            ],
          ]
        ],
        'dots_animation' => [
          'class' => '\MarvyElementor\animation\MarvyDotsAnimation',
          'dependency' => [
            'js'=>[
              [
                'name' => 'three',
                'src' => 'assets/js/lib/three.min.js'
              ],
              [
                'name' => 'vanta-dots',
                'src' => 'assets/js/lib/vanta.dots.min.js'
              ],
              [
                'name' => 'marvy-dots',
                'src' => 'assets/js/custom/marvy.dots.min.js'
              ]
            ],
          ]
        ],
        'fog_animation' => [
          'class' => '\MarvyElementor\animation\MarvyFogAnimation',
          'dependency' => [
            'js'=>[
              [
                'name' => 'three',
                'src' => 'assets/js/lib/three.min.js'
              ],
              [
                'name' => 'vanta-fog',
                'src' => 'assets/js/lib/vanta.fog.min.js'
              ],
              [
                'name' => 'marvy-fog',
                'src' => 'assets/js/custom/marvy.fog.min.js'
              ]
            ],
          ]
        ],
        'globe_animation' => [
          'class' => '\MarvyElementor\animation\MarvyGlobeAnimation',
          'dependency' => [
            'js'=>[
              [
                'name' => 'three',
                'src' => 'assets/js/lib/three.min.js'
              ],
              [
                'name' => 'vanta-globe',
                'src' => 'assets/js/lib/vanta.globe.min.js'
              ],
              [
                'name' => 'marvy-globe',
                'src' => 'assets/js/custom/marvy.globe.min.js'
              ]
            ],
          ]
        ],
        'halo_animation' => [
          'class' => '\MarvyElementor\animation\MarvyHaloAnimation',
          'dependency' => [
            'js'=>[
              [
                'name' => 'three',
                'src' => 'assets/js/lib/three.min.js'
              ],
              [
                'name' => 'vanta-halo',
                'src' => 'assets/js/lib/vanta.halo.min.js'
              ],
              [
                'name' => 'marvy-halo',
                'src' => 'assets/js/custom/marvy.halo.min.js'
              ]
            ],
          ]
        ],
        'net_animation' => [
          'class' => '\MarvyElementor\animation\MarvyNetAnimation',
          'dependency' => [
            'js'=>[
              [
                'name' => 'three',
                'src' => 'assets/js/lib/three.min.js'
              ],
              [
                'name' => 'vanta-net',
                'src' => 'assets/js/lib/vanta.net.min.js'
              ],
              [
                'name' => 'marvy-net',
                'src' => 'assets/js/custom/marvy.net.min.js'
              ]
            ],
          ]
        ],
        'trunk_animation' => [
          'class' => '\MarvyElementor\animation\MarvyTrunkAnimation',
          'dependency' => [
            'js'=>[
              [
                'name' => 'p5',
                'src' => 'assets/js/lib/p5.min.js'
              ],
              [
                'name' => 'vanta-trunk',
                'src' => 'assets/js/lib/vanta.trunk.min.js'
              ],
              [
                'name' => 'marvy-trunk',
                'src' => 'assets/js/custom/marvy.trunk.min.js'
              ]
            ],
          ]
        ],
        'fluid_animation' => [
            'class' => '\MarvyElementor\animation\MarvyFluidAnimation',
            'dependency' => [
                'js'=>[
                    [
                        'name' => 'marvy-fluid',
                        'src' => 'assets/js/custom/marvy.fluid.min.js'
                    ]
                ]
            ]
        ],
        'digitalStream_animation' => [
            'class' => '\MarvyElementor\animation\MarvyDigitalStreamAnimation',
            'dependency' => [
                'js'=>[
                    [
                        'name' => 'noise',
                        'src' => 'assets/js/lib/noise.min.js'
                    ],
                    [
                        'name' => 'marvy-digitalStream',
                        'src' => 'assets/js/custom/marvy.digitalStream.min.js'
                    ]
                ]
            ]
        ],
        'floating_heart_animation' => [
            'class' => '\MarvyElementor\animation\MarvyFloatingHeartAnimation',
            'dependency' => [
                'js'=>[
                    [
                        'name' => 'css-doodle',
                        'src' => 'assets/js/lib/css-doodle.min.js'
                    ],
                    [
                        'name' => 'marvy-floatingHeart',
                        'src' => 'assets/js/custom/marvy.floatingHeart.min.js'
                    ]
                ]
            ]
        ],
        'particles_wave_animation' => [
            'class' => '\MarvyElementor\animation\MarvyParticlesWaveAnimation',
            'dependency' => [
                'js'=>[
                    [
                        'name' => 'marvy-particlesWave',
                        'src' => 'assets/js/custom/marvy.particlesWave.min.js'
                    ]
                ]
            ]
        ],
        'dna_animation' => [
            'class' => '\MarvyElementor\animation\MarvyDNAAnimation',
            'dependency' => [
                'js'=>[
                    [
                        'name' => 'three',
                        'src' => 'assets/js/lib/three.min.js'
                    ],
                    [
                        'name' => 'tween',
                        'src' => 'assets/js/lib/tween.min.js'
                    ],
                    [
                        'name' => 'marvy-dna',
                        'src' => 'assets/js/custom/marvy.dna.min.js'
                    ]
                ]
            ]
        ],
        'beyblade_animation' => [
            'class' => '\MarvyElementor\animation\MarvyBeyBladeAnimation',
            'dependency' => [
                'js'=>[
                    [
                        'name' => 'marvy-beyblade',
                        'src' => 'assets/js/custom/marvy.beyblade.min.js'
                    ]
                ]
            ]
        ]
    ]
];