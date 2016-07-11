<?php

namespace Drupal\conflict;

interface ConflictManagerInterface {

    public function applies();

    public function addConflictResolver(ConflictResolverInterface $resolver);

    public function addAncestorResolver(ConflictAncestorResolverInterface $resolver);
}
