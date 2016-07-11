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
        $revid3 = $revision3->getRevisionId();
        if ($revid1 > $revid2 and $revid1 > $revid3) {
		  return $revid1;
		}
	  	elseif ($revid2 > $revid1 and $revid2 > $revid3) {
		  return $revid2;
		}
	  	else {
		  return $revid3;
		}
    }
}
