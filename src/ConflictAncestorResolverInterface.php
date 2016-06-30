<?php

namespace Drupal\conflict;

interface ConflictAncestorResolverInterface {

    public function applies();
    
    public function resolve($revision1, $revision2);
}