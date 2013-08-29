<?php

include 'Array2Xml.php';

/*
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
var_dump($a2x->setContext($a)->conv()) . PHP_EOL . PHP_EOL;


$a = [
    'root' => [
        'person' => [
            'gender' => 'male',
            'age' => '26',
            'name' => 'Александр',
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
*/

$a = [
    'pk' => [
        '@attributes' => [
            'excl' => 'web_actions',
            'system' => 'depWEBsys',
            'id' => 'packet20130821113908my_super_test1',
        ],
        'mes' => [
            '@attributes' => [
                't' => 'AddEvent',
                'id' => 'mes20130821113908my_super_test1',
            ],
            'ev' => [
                '@attributes' => [
                    'evt' => '010038',
                    'src' => 'NKK',
                    'st' => 'WT',
                    'start' => '20130821113908',
                    'addrtype' => 'MB',
                    'addrid' => '+380957700418',
                    'bank' => 'PB',
                    'lang' => 'RU',
                ],
                'attr' => [
                    [
                        '@attributes' => [
                            'code' => 'SUBJ',
                            'val' => 'letter subject',
                        ],
                    ],
                    [
                        '@attributes' => [
                            'code' => 'MAILTO',
                            'val' => 'yagmikita@gmail.com',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
$a2x = new Array2Xml($a);
var_dump($a2x->conv());