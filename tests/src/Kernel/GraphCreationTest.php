<?php

namespace Drupal\Tests\conflict\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Fhaculty\Graph\Graph;

class GraphCreationTest extends KernelTestBase {

  public function testTreeToGraph() {
    $graph = new Graph();
    $tree_array = array(
      array(
        '#type' => 'rev',
        '#uuid' => $uuid,
        '#rev' => $revs[0],
        '#rev_info' => array(
          'status' => 'available',
          'default' => FALSE,
          'open_rev' => FALSE,
          'conflict' => FALSE,
        ),
        'children' => array(
          array(
            '#type' => 'rev',
            '#uuid' => $uuid,
            '#rev' => $revs[1],
            '#rev_info' => array(
              'status' => 'available',
              'default' => FALSE,
              'open_rev' => FALSE,
              'conflict' => FALSE,
            ),
            'children' => array(
              array(
                '#type' => 'rev',
                '#uuid' => $uuid,
                '#rev' => $revs[2],
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
                '#uuid' => $uuid,
                '#rev' => $revs[3],
                '#rev_info' => array(
                  'status' => 'available',
                  'default' => FALSE,
                  'open_rev' => FALSE,
                  'conflict' => FALSE,
                ),
                'children' => array(
                  array(
                    '#type' => 'rev',
                    '#uuid' => $uuid,
                    '#rev' => $revs[4],
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
            '#uuid' => $uuid,
            '#rev' => $revs[5],
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
    $rev_ids = array();
    $this->storeNodesId($tree_array, $rev_ids);
    $vertices = $this->generateVertices($graph, $rev_ids);
    $this->generateEdges($vertices,$tree_array);

    /*
     * Shape of tree is:
     *              0
     *            /  \
     *           1    5
     *         /  \
     *        2    3
     *              \
     *               4
     */
    $this->assertEquals($vertices[1]->getVerticesEdgeFrom()->getId(), 0);
    $this->assertEquals($vertices[2]->getVerticesEdgeFrom()->getId(), 1);
    $this->assertEquals($vertices[3]->getVerticesEdgeFrom()->getId(), 1);
    $this->assertEquals($vertices[4]->getVerticesEdgeFrom()->getId(), 3);
    $this->assertEquals($vertices[5]->getVerticesEdgeFrom()->getId(), 0);
  }

  /**
   * Stores all revision IDs in an array.
   *
   * @param $tree_array : Array containing information about tree
   * @param $rev_ids : Array to store all revision ID.
   */
  public function storeNodesId($tree_array, &$revision_ids) {
    foreach ($tree_array as $value) {
      $current_id = $value['#rev'];
      $revision_ids[$current_id] = $current_id;
      if (count($value['children'])) {
        $this->storeNodesId($value['children'], $revision_ids);
      }
    }
  }

  /**
   * Create Edges between parent and children.
   *
   * @param $revisions_array : An array which stores graph nodes.
   * @param $tree_array : Array containing tree information.
   * @param int $parent : Parent ID.
   */
  public function generateEdges($revisions_array, $tree_array, $parent = -1 ) {
    foreach ($tree_array as $item) {
      $current_id =$item['#rev'];
      if($parent != -1) {
        $revisions_array[$parent]->createEdgeTo($revisions_array[$current_id]);
      }
      if(count($item['children'])) {
        $this->generateEdges($revisions_array, $item['children'], $current_id);
      }
    }
  }

  /**
   * Generates vertices for Graph.
   *
   * @param Graph $graph : Graph class object
   * @param int $count : Number of nodes.
   * @return \Fhaculty\Graph\Vertex[]
   */
  public function generateVertices(Graph $graph, $revision_ids) {
    foreach ($revision_ids as $id) {
      $ids[] = $id;
    }
    return $graph->createVertices($ids)->getMap();
  }
}

