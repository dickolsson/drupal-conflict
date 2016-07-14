<?php

namespace Drupal\conflict;

use Drupal\Core\Entity\RevisionableInterface;

class SimpleMergeResolver implements ConflictResolverInterface
{
  public function applies()
  {
    return True;
  }

  public function SimpleMergeResolver(RevisionableInterface $revision1, RevisionableInterface $revision2, RevisionableInterface $revision3)
  {
    $revid1 = $revision1->getRevisionId();
    $revid2 = $revision2->getRevisionId();
    $revid3 = $revision2->getRevisionId();
    return min($revid1, $revid2, $revid3);
  }
}
