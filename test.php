<?php

include 'Array2Xml.php';

$a = [
    'root' => [
        '@attributes' => [
            'attr1' => '1',
        ],
    ],
];
$a2x = new Array2Xml($a);
var_dump($a2x->conv()) . PHP_EOL . PHP_EOL;


$a = [
    'root' => [
        'message' => [
            '@content' => 'This is text content',
        ],
    ],
];
var_dump($a2x->setContext($a)->conv()) . PHP_EOL . PHP_EOL;


$a = [
    'root' => [
        'people' => [
            'person' => [
                [
                    '@content' => 'Alex',
                    '@attributes' => [
                        'mood' => 'poor',
                    ],                    
                ],
                [
                    '@attributes' => [
                        'mood' => 'good',
                    ],
                    '@content' => 'Max',
                ],
                [
                    '@content' => 'Eugen',
                ],
            ],
        ],
    ],
];
var_dump($a2x->setContext($a)->conv()) . PHP_EOL . PHP_EOL;


$a = [
    'root' => [
        '@attributes' => [
            'type' => 'test_type',
            'id' => 'test_id',
            'text' => 'русский текст'
        ],
        'main' => [
            '@attributes' => [
                'uid' => 'u201j3a0828ki3si0',
                'src' => 'open',
                'start' => '12423511247',
                'stop' => '12423991978',
                'adtp' => 'dbt',
                'clid' => '100500',
            ],
            'attr' => [
                [
                    '@attributes' => [
                        'code' => '1',
                        'val' => '11',
                    ],
                ],
                [
                    '@attributes' => [
                        'code' => '2',
                        'val' => '12',
                    ],
                ],
            ],
            'history' => [
                [
                    '@attributes' => [
                        'at1' => '1',
                        'at2' => '2',
                        'at3' => '3',
                        'at4' => 'test',
                    ],
                ],
            ],
            'person' => [
                'gender' => [
                    '@content' => 'male'
                ],
                'age' => [
                    '@content' => 26,
                ],
                'name' => [
                    '@content' => 'Александр'
                ],
            ],
        ],
    ],
];
var_dump($a2x->setContext($a)->conv());