<?php

namespace Drupal\Tests\conflict\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Fhaculty\Graph\Graph;

/**
 * @group conflict
 */
class GraphCreationTest extends KernelTestBase {

  public function testTreeToGraph() {
    $tree = array(
      array(
        '#type' => 'rev',
        '#rev' => '0-zzzf2d5d944d64db082b484bc1088pqr',
        '#rev_info' => array(
          'status' => 'available',
          'default' => FALSE,
          'open_rev' => FALSE,
          'conflict' => FALSE,
        ),
        'children' => array(
          array(
            '#type' => 'rev',
            '#rev' => '1-e4af2d5d944d64db082b484bc1088d1a',
            '#rev_info' => array(
              'status' => 'available',
              'default' => FALSE,
              'open_rev' => FALSE,
              'conflict' => FALSE,
            ),
            'children' => array(
              array(
                '#type' => 'rev',
                '#rev' => '2-abcf2d5d944d64db082b484bc1088cde',
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
                '#rev' => '3-zzzf2d5d944d64db082b484bc1088cde',
                '#rev_info' => array(
                  'status' => 'available',
                  'default' => FALSE,
                  'open_rev' => FALSE,
                  'conflict' => FALSE,
                ),
                'children' => array(
                  array(
                    '#type' => 'rev',
                    '#rev' => '4-zzzf2d5d944d64db082b412gh1088cde',
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
            '#rev' => '5-zzzf2d5d345d64db082b484bc1088cde',
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
    $graph = $this->getGraph($tree);
    $vertices = $graph->getVertices()->getMap();

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
    foreach ($vertices['1-e4af2d5d944d64db082b484bc1088d1a']->getVerticesEdgeFrom() as $parent) {
      $this->assertEquals($parent->getId(), '0-zzzf2d5d944d64db082b484bc1088pqr');
    }
    foreach ($vertices['2-abcf2d5d944d64db082b484bc1088cde']->getVerticesEdgeFrom() as $parent) {
      $this->assertEquals($parent->getId(), '1-e4af2d5d944d64db082b484bc1088d1a');
    }
    foreach ($vertices['3-zzzf2d5d944d64db082b484bc1088cde']->getVerticesEdgeFrom() as $parent) {
      $this->assertEquals($parent->getId(), '1-e4af2d5d944d64db082b484bc1088d1a');
    }
    foreach ($vertices['4-zzzf2d5d944d64db082b412gh1088cde']->getVerticesEdgeFrom() as $parent) {
      $this->assertEquals($parent->getId(), '3-zzzf2d5d944d64db082b484bc1088cde');
    }
    foreach ($vertices['5-zzzf2d5d345d64db082b484bc1088cde']->getVerticesEdgeFrom() as $parent) {
      $this->assertEquals($parent->getId(), '0-zzzf2d5d944d64db082b484bc1088pqr');
    }
  }

  public function getGraph($tree) {
    $graph = new Graph();
    $rev_ids = array();
    $this->storeNodesId($tree, $rev_ids);
    $vertices = $this->generateVertices($graph, $rev_ids);
    $this->generateEdges($vertices,$tree);
    return $graph;
  }

  /**
   * Stores all revision IDs in an array.
   *
   * @param $tree : Array containing information about tree
   * @param $rev_ids : Array to store all revision ID.
   */
  protected function storeNodesId($tree, &$revision_ids) {
    foreach ($tree as $value) {
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
   * @param $tree : Array containing tree information.
   * @param int $parent : Parent ID.
   */
  protected function generateEdges($revisions_array, $tree, $parent = -1 ) {
    foreach ($tree as $item) {
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
  protected function generateVertices(Graph $graph, $revision_ids) {
    foreach ($revision_ids as $id) {
      $ids[] = $id;
    }
    return $graph->createVertices($ids)->getMap();
  }
}
