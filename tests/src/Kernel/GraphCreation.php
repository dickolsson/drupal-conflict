<?php

namespace Relaxed\LCA\Test;
require_once __DIR__."/../vendor/autoload.php";
use Fhaculty\Graph\Graph as Graph;


class GraphCreation
{

    public function abc() {
        $array1 = array(
            array(
                '#type' => 'rev',
//                '#uuid' => $uuid,
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
//                        '#uuid' => $uuid,
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
//                                '#uuid' => $uuid,
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
//                                '#uuid' => $uuid,
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
//                                        '#uuid' => $uuid,
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
//                        '#uuid' => $uuid,
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
//        print_r($array1);
        $x = $this->creator($array1);
    }

    public function creator($arr) {
        $vertices = [];
        $graph = new Graph();
        foreach ($arr as $value) {
            array_push($vertices,$value['#rev']);
            if (count($value['children'])) {
                $this->creator($value['children']);
            }
        }
        print_r($vertices);
        return $vertices;
    }
}

$a = new GraphCreation();
$a->abc();