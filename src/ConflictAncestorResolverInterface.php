<?php

namespace Drupal\conflict;

/**
 * Provides an interface for defining Lca resolver entities.
 *
 * @ingroup conflict
 */
interface ConflictAncestorResolverInterface {
    
    public function resolve($revision1, $revision2);
}