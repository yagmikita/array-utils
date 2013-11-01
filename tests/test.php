<?php

require_once realpath(__DIR__ . '/../vendor/autoload.php');

use \ArrayUtils\Array2Xml;

function encode($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

$a = [
    'root' => [
        '@attributes' => [
            'attr1' => '1',
        ],
    ],
];
$a2x = new Array2Xml($a);
echo encode($a2x->conv()) . '<br/><br/>';


$a = [
    'root' => [
        'message' => [
            '@content' => 'This is text content',
        ],
    ],
];
echo encode($a2x->setContext($a)->conv()) . '<br/><br/>';


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
                    'test' => [
                        '@attributes' => [
                            'favicon' => '/img/favicon.ico',
                        ],
                        'test-level2' => [
                            '@content' => 'level2 test content',
                            'enum' => [
                                [
                                    '@attributes' => [
                                    ],
                                ],
                                [
                                    '@attributes' => [
                                        'nothing' => 'so far',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
echo encode($a2x->setContext($a)->conv()) . '<br/><br/>';


$a = [
    'root' => [
        'person' => [
            'gender' => 'male',
            'age' => '26',
            'name' => 'Александр',
        ],
    ],
];
echo encode($a2x->setContext($a)->conv()) . '<br/><br/>';


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
echo encode($a2x->setContext($a)->conv());