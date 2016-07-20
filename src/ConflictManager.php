<?php

namespace Drupal\conflict;

use Drupal\Core\Entity\RevisionableInterface;

class ConflictManager
{
  protected $resolvers = [];
    
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
}
