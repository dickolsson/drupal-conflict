<?php

namespace Relaxed\LCA\Test;
require_once __DIR__."/../vendor/autoload.php";
use Fhaculty\Graph\Graph as Graph;


class GraphCreation
{
    public function rev_store($old)
    {
        if(array_key_exists('#rev', $old)){
            $index[] = $old['#rev'];
            foreach ($old['children'] as $values)
            $this->rev_store($values);
        }
        else {
           foreach ($old as $item) {
               $index[] = $item['#rev'];
           }
            foreach ($item['children'] as $value) {
               $this->rev_store($value);
           }
       }
        print_r($index);
        return $index;
    }
    public function simipleTest()
    {
        $values = array();
        $graph = new Graph();
        $index = [];
        $old = array(
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
        $values = $this->rev_store($old);
        return $values;
    }

}

$a = new GraphCreation();
$b = $a->simipleTest();
//print_r($b);