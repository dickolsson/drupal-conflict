<?php

namespace Drupal\conflict;

use Drupal\conflict\ConflictAncestorResolverInterface;

class ConflictManager
{

    protected $resolvers = [];

    public function addLcaResolver(ConflictAncestorResolverInterface $resolver)
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
        return -1;
    }
}
