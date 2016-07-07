<?php

namespace Drupal\conflict;

class SimpleLcaResolver implements ConflictAncestorResolverInterface
{
    public function resolve($revision1, $revision2) {
      if ($revision1 < $revision2) {
            return $revision1-1;
        }
        return $revision2-1;
    }

    public function applies()
    {
        return True;
    }
}
