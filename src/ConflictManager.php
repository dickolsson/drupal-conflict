<?php

namespace Drupal\conflict;

use Drupal\conflict\ConflictManagerInterface;
use Drupal\conflict\ConflictAncestorResolverInterface;

class ConflictManager implements ConflictManagerInterface {

    protected $resolvers = [];

    public function applies() {
        return TRUE;
    }
    
    public function addResolver(ConflictManagerInterface $resolver) {
        $this->resolvers[] = $resolver;
    }
}