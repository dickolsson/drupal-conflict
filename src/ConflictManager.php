<?php

namespace Drupal\conflict;

class ConflictManager implements ConflictManagerInterface {

    public function addAncestorResolver(ConflictAncestorResolverInterface $resolver)
    {
        // TODO: Implement addAncestorResolver() method.
    }

    public function addConflictResolver(ConflictResolverInterface $resolver)
    {
        // TODO: Implement addConflictResolver() method.
    }

    public function resolveLowestCommonAncestor($revision1, $revision2)
    {
        // TODO: Implement resolveLowestCommonAncestor() method.
    }

    public function resolveConflict($revision1, $revision2, $revision3)
    {
        // TODO: Implement resolveConflict() method.
    }
}