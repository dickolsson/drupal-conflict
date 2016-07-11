<?php

namespace Drupal\conflict;

use Drupal\Core\Entity\RevisionableInterface;

class ConflictManager
{

    protected $resolvers = [];

    /**
     * 
     * @param ConflictAncestorResolverInterface $resolver
     */
    public function addLcaResolver(ConflictAncestorResolverInterface $resolver)
    {
        $this->resolvers[] = $resolver;
    }
    
    public function addConflictResolver(ConflictResolverInterface $resolver)
    {
        $this->resolvers[] = $resolver;
    }
    
    public function resolveSimpleMerge(RevisionableInterface $revision1, RevisionableInterface $revision2, RevisionableInterface $revision3)
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->applies()) {
                return $resolver->SimpleMergeResolver($revision1, $revision2, $revision3);
            }
        }
    }

    /**
     * @param RevisionableInterface $revision1
     * @param RevisionableInterface $revision2
     * 
     * @return int revision_ID
     */
    public function resolveLowestCommonAncestor(RevisionableInterface $revision1, RevisionableInterface $revision2)
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->applies()) {
                return $resolver->resolve($revision1, $revision2);
            }
        }
    }
}
