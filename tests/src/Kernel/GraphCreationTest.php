<?php

namespace Drupal\Tests\conflict\Kernel;

use Fhaculty\Graph\Graph;
use Drupal\KernelTests\KernelTestBase;

class GraphCreationTest extends KernelTestBase {

    public function getNodesId($arr, &$storage) {
        foreach ($arr as $value) {
            $x = $value['#rev'];
            $storage[$x] = $x;
            if (count($value['children'])) {
                $this->getNodesId($value['children'], $storage);
            }
        }
    }

    public function testTreeToGraph() {
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
        $this->getNodesId($array1, $storage);
        // Creating graph nodes here
        $vertices = $this->generateVertices($graph, count($storage));
        $this->generateEdges($vertices,$array1);
        foreach ($vertices[2]->getVerticesEdgeFrom() as $a) {
            echo $a->getId().' '.PHP_EOL;
        }
    }

    public function generateEdges($rev_array, $source, $par = -1 ) {
        foreach ($source as $item) {
            $current =$item['#rev'];
            if($par != -1) {
                $rev_array[$par]->createEdgeTo($rev_array[$current]);
            }
            if(count($item['children'])) {
                $this->generateEdges($rev_array, $item['children'], $current);
            }
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
$a = new GraphCreationTest();
$a->abc();
