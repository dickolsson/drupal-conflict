<?php

namespace Drupal\conflict;

use Drupal\Core\Entity\RevisionableInterface;

interface ConflictResolverInterface {

  /**
   * @param Drupal\Core\Entity\RevisionableInterface $revision1
   * @param Drupal\Core\Entity\RevisionableInterface $revision2
   * @param Drupal\Core\Entity\RevisionableInterface $revision3
   *
   * @return mixed
   *  Last created revision's Id.
   */
  public function merge(RevisionableInterface $revision1,RevisionableInterface $revision2, RevisionableInterface $revision3);

}
