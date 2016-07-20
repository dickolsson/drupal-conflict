<?php
function creator($arr, &$storage) {
    foreach ($arr as $value) {
        $x = $value['#rev'];
        $storage[$x] = $x;
        if (count($value['children'])) {
            creator($value['children'], $storage);
        }
    }
}

$array1 = array(
    array(
        '#type' => 'rev',
        '#rev' => 0,
        '#rev_info' => array(
            'status' => 'available',
            'default' => FALSE,
            'open_rev' => FALSE,
            'conflict' => FALSE,
        ),
        'children' => array(
            array(
                '#type' => 'rev',
                '#rev' => 1,
                '#rev_info' => array(
                    'status' => 'available',
                    'default' => FALSE,
                    'open_rev' => FALSE,
                    'conflict' => FALSE,
                ),
                'children' => array(
                    array(
                        '#type' => 'rev',
                        '#rev' => 2,
                        '#rev_info' => array(
                            'status' => 'available',
                            'default' => FALSE,
                            'open_rev' => TRUE,
                            'conflict' => TRUE,
                        ),
                        'children' => array(),
                    ),
                    array(
                        '#type' => 'rev',
                        '#rev' => 3,
                        '#rev_info' => array(
                            'status' => 'available',
                            'default' => FALSE,
                            'open_rev' => FALSE,
                            'conflict' => FALSE,
                        ),
                        'children' => array(
                            array(
                                '#type' => 'rev',
                                '#rev' => 4,
                                '#rev_info' => array(
                                    'status' => 'available',
                                    'default' => TRUE,
                                    'open_rev' => TRUE,
                                    'conflict' => FALSE,
                                ),
                                'children' => array(),
                            )
                        )
                    )
                )
            ),
            array(
                '#type' => 'rev',
                '#rev' => 5,
                '#rev_info' => array(
                    'status' => 'available',
                    'default' => FALSE,
                    'open_rev' => TRUE,
                    'conflict' => TRUE,
                ),
                'children' => array(),
            )
        )
    )
);
$storage = array();
creator($array1, $storage);
print_r($storage);
