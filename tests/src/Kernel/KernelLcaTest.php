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
    public static $modules = ['entity_test'];
    
    public function testsimple  () {
        $entity = EntityTest::create(['label' => 'revision 1']);
        $entity->save();
        $entity->label = ['revision 2'];
        $entity->save();
        $entity->label = ['revision 3'];
        $entity->save();

        $revision2 = EntityTest::load(2);
        $revision3 = EntityTest::load(3);

        $manager = Drupal::service('conflict.conflict_manager');
        $revisionLca = $manager->resolveLowestCommonAncestor($revision2, $revision3);
        $this->assertTrue($revisionLca->label() == 'revision 1');
    }
}
