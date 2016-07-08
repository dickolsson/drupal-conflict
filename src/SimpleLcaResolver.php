<?php

namespace Drupal\conflict;

use Drupal\Core\Entity\RevisionableInterface;

class SimpleLcaResolver implements ConflictAncestorResolverInterface
{
    public function applies()
    {
        return True;
    }

    public function resolve(RevisionableInterface $revision1,RevisionableInterface $revision2) {
        $revid1 = $revision1->getRevisionId();
        $revid2 = $revision2->getRevisionId();
        if ($revid1 < $revid2) {
            return $revid1-1;
        }
        return $revid2-1;
    }

}
