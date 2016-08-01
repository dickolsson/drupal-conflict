<?php

namespace Drupal\conflict;
use Fhaculty\Graph\Graph;
use Drupal\Core\Entity\RevisionableInterface;

/**
 * Provides an interface for defining Lca resolver entities.
 *
 * @ingroup conflict
 */
interface ConflictAncestorResolverInterface {

  public function resolve(RevisionableInterface $revision1,RevisionableInterface $revision2, Graph $graph);

}
