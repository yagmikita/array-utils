ArrayUtils
=========

 * Array2Xml -  class uses SimpleXMLElement class to recursively convert PHP associative array into XML-formatted string.
 * ArrayIterator - class converts PHP array to an itarable object (less memory consumption then the same in SPL-library).

Array2Xml use cases:
==========
 * Instantiate the converter:
```php
 	<?php
        require_once realpath(__DIR__ . '/../vendor/autoload.php');
        use \ArrayUtils\Array2Xml;
```
 * in order to to add attributes - add key '@attributes', ex.:
```php
 		$a = [
 			'root' => [
 				'@attributes' => [
 					'attr1' => '1',
 				],
 			],
 		];
        $a2x = new Array2Xml($a);
        echo $a2x->conv();
```
    Output:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<root attr1="1"/>
```

 * in order to add text content to the node - add key '@content', ex.:
```php
	<?php
		$a = [
		    'root' => [
		        'message' => [
		            '@content' => 'This is text content',
		        ],
		    ],
		];
        $a2x = new Array2Xml($a);
        echo $a2x->conv();
```
    Output:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<root>
  <message>This is text content</message>
</root>
```

 * short '@content' syntax, ex.:
```php
 	<?php
		$a = [
		    'root' => [
		        'person' => [
		            'gender' => 'male',
		            'age' => '26',
		            'name' => 'Александр',
		        ],
		    ],
		];
        $a2x = new Array2Xml($a);
        echo $a2x->conv();
```
    Output:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<root>
  <person>
    <gender>male</gender>
    <age>26</age>
    <name>Александр</name>
  </person>
</root>
```

 * in order to add tags with the same name add an array of the enumerated elements with the key of desired keys names, ex.:
```php
 	<?php
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
        $a2x = new Array2Xml($a);
        echo $a2x->conv();
```
    Output:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<root type="test_type" id="test_id" text="русский текст">
  <main uid="u201j3a0828ki3si0" src="open" start="12423511247" stop="12423991978" adtp="dbt" clid="100500">
    <attr code="1" val="11"/>
    <attr code="2" val="12"/>
    <history at1="1" at2="2" at3="3" at4="test"/>
    <person>
      <gender>male</gender>
      <age>26</age>
      <name>Александр</name>
    </person>
  </main>
</root>
```
