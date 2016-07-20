<?php

namespace Relaxed\LCA\Test;
require_once __DIR__."/../vendor/autoload.php";
use Fhaculty\Graph\Graph as Graph;


class GraphCreation
{
    public function creator($arr, &$storage) {
        foreach ($arr as $value) {
            $x = $value['#rev'];
            $storage[$x] = $x;
            if (count($value['children'])) {
                $this->creator($value['children'], $storage);
            }
        }
    }

    public function abc() {
        $graph = new Graph();
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
        $this->creator($array1, $storage);
        // Creating graph nodes here
        $vertices = $this->generateVertices($graph, count($storage));
        // TODO: Automatic edge creation
        // Creating edges manually
        $vertices[0]->createEdge($vertices[1]);
        $vertices[1]->createEdge($vertices[2]);
        foreach ($vertices[2]->getVerticesEdgeFrom() as $a) {
            echo $a->getId().' leads to 2'.PHP_EOL;
        }

    }
    public function generateVertices(Graph $graph, $count = 5)
    {
        for ($i = 0; $i < $count; $i++) {
            $ids[] = $i;
        }
        return $graph->createVertices($ids)->getMap();
    }

}
$a = new GraphCreation();
$a->abc();