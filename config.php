<?php
use App\Skill\MagicShield;
use App\Skill\RapidStrike;

return [
    'main' => [
        'rounds' => 20
    ],
    'players' => [
        'first_player' => [
            'name' => 'Stanhope',
            'health' => [
                'min' => 70,
                'max' => 100
            ],
            'strength' => [
                'min' => 70,
                'max' => 80
            ],
            'defence' => [
                'min' => 45,
                'max' => 55
            ],
            'speed' => [
                'min' => 40,
                'max' => 50
            ],
            'luck' => [
                'min' => 10,
                'max' => 30
            ],
            'skills' => [
                [
                    'name' => MagicShield::class,
                    'chance' => 20
                ], [
                    'name' => RapidStrike::class,
                    'chance' => 10
                ],
            ]
        ],

        'second_player' => [
            'name' => 'Wild beast',
            'health' => [
                'min' => 60,
                'max' => 90
            ],
            'strength' => [
                'min' => 60,
                'max' => 90
            ],
            'defence' => [
                'min' => 40,
                'max' => 60
            ],
            'speed' => [
                'min' => 40,
                'max' => 60
            ],
            'luck' => [
                'min' => 25,
                'max' => 40
            ],
            'skills' => [],
        ]
    ]
];