<?php

namespace Drupal\conflict;

interface ConflictManagerInterface {

    public function addAncestorResolver(ConflictAncestorResolverInterface $resolver);

    public function addConflictResolver(ConflictResolverInterface $resolver);

    public function resolveLowestCommonAncestor($revision1, $revision2);

    public function resolveConflict($revision1, $revision2, $revision3);
    
}
