<?php
declare(strict_types=1);
namespace Cpsit\CpsDownload\Tests\Functional\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Cpsit\CpsDownload\Domain\Model\Dto\DownloadDemand;
use Cpsit\CpsDownload\Domain\Repository\DownloadRepository;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class DownloadRepositoryTest extends FunctionalTestCase
{
    /**
     * @var DownloadRepository|MockObject
     */
    protected $subject;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    protected $testExtensionsToLoad = ['typo3conf/ext/cps_download'];

    /**
     * @var QueryInterface|MockObject
     */
    protected $query;

    /**
     * @var QueryResultInterface|MockObject
     */
    protected $result;

    public function setUp(): void
    {
        parent::setUp();
        /** @var ObjectManager|ObjectManagerInterface $objectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->subject = $this->objectManager->get(DownloadRepository::class);

        $fixturePath = ORIGINAL_ROOT . 'typo3conf/ext/cps_download/Tests/Functional/Fixtures/Database/';
        $this->importDataSet($fixturePath . 'tx_cpsdownload_domain_model_download.xml');
    }

    public function testFindAll(): void
    {
        $result = $this->subject->findAll();
        self::assertEmpty($result);
    }

    public function testFindDemandedFindsDownloadsBySinglePageId(): void
    {
        $pages = [1];
        $demand = new DownloadDemand();
        $demand->setPageIds($pages);
        $result = $this->subject->findDemanded($demand);
        self::assertCount(
            1,
            $result->toArray()
        );
    }

    public function testFindDemandedFindsDownloadsByPageIds(): void
    {
        $pages = [1,3];
        $demand = new DownloadDemand();
        $demand->setPageIds($pages);
        $result = $this->subject->findDemanded($demand);
        self::assertCount(
            2,
            $result
        );
    }

}
