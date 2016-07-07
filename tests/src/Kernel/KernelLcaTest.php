<?php

namespace Drupal\Tests\conflict\Kernel;

use Drupal;
use Drupal\entity_test\Entity\EntityTest;
use Drupal\KernelTests\KernelTestBase;
use Drupal\conflict;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\simpletest\TestBase;

/**
 * @group conflict
 */
class KernelLcaTest extends EntityKernelTestBase {
    /**
     * Modules to enable.
     *
     * @var array
     */
    public static $modules = ['entity_test', 'conflict'];
    
    public function testsimple  () {
        $entity = EntityTest::create(['label' => 'revision 1']);
        $entity->save();
        $entity->label = ['revision 2'];
        $entity->save();
        $entity->label =['revision 3'];
        $entity->save();
        $revision2 = Drupal::entityTypeManager()
            ->getStorage('entity_test')
            ->loadRevision(2);
        $revision3 = Drupal::entityTypeManager()
            ->getStorage('entity_test')
            ->loadRevision(3);

        $manager = Drupal::service('conflict.conflict_manager');
        $revisionLca = $manager->resolveLowestCommonAncestor($revision2, $revision3);
        $this->assertFalse($revisionLca == "revision 1");
    }
}
