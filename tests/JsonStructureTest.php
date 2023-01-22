<?php

use Hyperlink\JsonStructure\Actions\DecodeJsonStructure;

test('that the json command returns a valid answer', function () {
    $array = [
        'key1' => 'value1',
        'keys1' => [
            'key2' => 'value2',
            'key3' => 'value3',
        ],
        'keys2' => [
            [
                'key4' => 'value4',
                'key5' => 'value5',
            ],
            [
                'key4' => 'value6',
                'key5' => 'value7',
            ],
        ],
    ];


    $result = call_user_func(new DecodeJsonStructure($array));

    $this->assertEquals($result,
        "[
    'key1',
    'keys1' => [
        'key2',
        'key3'
    ],
    'keys2' => [
        '*' => [
            'key4',
            'key5'
        ]
    ]
]
");
});
