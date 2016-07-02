<?php

namespace Drupal\conflict\Tests;

use Drupal\Tests\UnitTestCase;
use Drupal\Core\Entity\Entity;
use Drupal\conflict;

class SimpleLcaTest extends UnitTestCase {

    public function basicTest() {
        $entity = EntityTest::create(['label' => 'revision 1']);
        $entity->save();
        $entity->label = 'revision 2';
        $entity->save();
        $entity->label = 'revision 3';
        $entity->save();

        $revision2 = entity_revision_load('entity_test', 2);
        $revision3 = entity_revision_load('entity_test', 3);

        $manager = Drupal::service('conflict.manager');
        $revisionLca = $manager->resolveLowestCommonAncestor($revision2, $revision3);
        $this->assertTrue($revisionLca->label() == 'revision 1');
    }
}
