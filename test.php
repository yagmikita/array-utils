<?php

$context = [
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



include 'Array2Xml.php';
$a2x = new Array2Xml($context);
var_dump($a2x->conv());