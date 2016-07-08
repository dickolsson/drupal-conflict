<?php

namespace Drupal\conflict;

use Drupal\Core\Entity\RevisionableInterface;

class ConflictManager
{

    protected $resolvers = [];

    public function addLcaResolver(ConflictAncestorResolverInterface $resolver)
    {
        $this->resolvers[] = $resolver;
    }

    public function resolveLowestCommonAncestor(RevisionableInterface $revision1, RevisionableInterface $revision2)
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->applies()) {
                return $resolver->resolve($revision1, $revision2);
            }
        }
    }
}
