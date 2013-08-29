array2xml
=========

Array2Xml class uses SimpleXMLElement class to recursivly convert php associative array into xml-formatted string.

Use cases:
==========
 * in order to to add attributes - add key '@attributes', ex.:
```php
 	<?php
 		$a = [
 			'root' => [
 				'@attributes' => [
 					'attr1' => '1',
 				],
 			],
 		];
```

 * in order to add text content to the node - add key '@content', ex.:
```php
 	<?php
 		$a = [
 			'root' => [
 				'@content' => 'This is text content',
 			],
 		];
```

 * short '@content' synthax, ex.:
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
```

 * in order to add tags with the same name add an array of the enumerated elements with the key of desired keys names, ex.:
```php
 	<?php
 		$a = [
 			'root' => [
 				'people' => [
 					'person' => [
 						[
 							'@content' => 'Alex'
 						],
 						[
 							'@content' => 'Max'
 						],
 						[
 							'@content' => 'Eugen'
 						],
 					],
 				],
 			],
 		];
```
