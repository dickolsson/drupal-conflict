<?php

namespace Drupal\conflict;

use Drupal\conflict\ConflictManagerInterface;
use Drupal\conflict\ConflictAncestorResolverInterface;

class ConflictManager implements ConflictManagerInterface {

    protected $resolvers = [];

    public function applies() {
        return TRUE;
    }
    
    public function addLcaResolver(ConflictManagerInterface $resolver) {
        $this->resolvers[] = $resolver;
    }

    public function resolveLowestCommonAncestor($revision1, $revision2)
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->applies()) {
                return $resolver->resolve($revision1, $revision2);
            }
        }
        return -1;
    }
}