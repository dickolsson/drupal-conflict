<?php

namespace Drupal\conflict;


use Symfony\Component\Validator\Constraints\True;

class LcaResolver implements ConflictManagerInterface
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