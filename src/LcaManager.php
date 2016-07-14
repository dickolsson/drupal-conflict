<?php

namespace Drupal\conflict;

use Drupal\Core\Entity\RevisionableInterface;

class LcaManager
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
