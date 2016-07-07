<?php

namespace Drupal\conflict;


use Symfony\Component\Validator\Constraints\True;

class LcaResolver implements ConflictManagerInterface
{

    protected $resolvers = [];

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
        $revid1 = $revision1->id();
        $revid2 = $revision2->id();

        if ($revid1 < $revid2) {
            return $revid1-1;
        }
        return $revid2-1;
    }

    public function applies()
    {
        return True;
    }
}