<?php

namespace Drupal\conflict;

use Drupal\Core\Entity\RevisionableInterface;

interface ConflictResolverInterface {

  public function SimpleMergeResolver(RevisionableInterface $revision1,RevisionableInterface $revision2, RevisionableInterface $revision3);

}
