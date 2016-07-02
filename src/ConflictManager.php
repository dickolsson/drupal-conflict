<?php

namespace Drupal\conflict;

use Drupal\conflict\ConflictManagerInterface;
use Drupal\conflict\ConflictAncestorResolverInterface;

class ConflictManager implements ConflictManagerInterface {

    protected $resolvers = [];

    public function applies() {
        return TRUE;
    }

    public function addAncestorResolver(ConflictAncestorResolverInterface $resolver)
    {
        $this->resolvers[] = $resolver;
    }

    public function resolveLowestCommonAncestor($revision1, $revision2)
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->applies()) {
                return $resolver->resolve($revision1, $revision2);
            }
        }
        echo "No revision found";
        return -1;
    }

    public function resolve($revision1, $revision2) {
        if ($revision1 < $revision2) {
            return $revision1-1;
        }
        return $revision2-1;
    }

    public function addConflictResolver(ConflictResolverInterface $resolver)
    {
        // TODO: Implement addConflictResolver() method.
    }


    public function resolveConflict($revision1, $revision2, $revision3)
    {
        // TODO: Implement resolveConflict() method.
    }
}