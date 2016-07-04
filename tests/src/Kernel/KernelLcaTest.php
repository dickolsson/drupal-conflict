<?php

namespace Drupal\Tests\conflict\Kernel;

use Drupal\entity_test\Entity\EntityTest;
use Drupal\KernelTests\KernelTestBase;
use Drupal\conflict;
/**
 * @group conflict
 */
class KernelLcaTest extends KernelTestBase {

    public function testsimple  () {
        $entity = EntityTest::create(['label' => 'revision 1']);
        $entity->save();
        $entity->label = 'revision 2';
        $entity->save();
        $entity->label = 'revision 3';
        $entity->save();

        $revision2 = entity_revision_load('entity_test', 2);
        $revision3 = entity_revision_load('entity_test', 3);

        $manager = Drupal::service('conflict.conflict_manager');
        $revisionLca = $manager->resolveLowestCommonAncestor($revision2, $revision3);
        $this->assertTrue($revisionLca->label() == 'revision 1');
    }
}
