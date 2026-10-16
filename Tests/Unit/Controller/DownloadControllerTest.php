<?php

declare(strict_types=1);

namespace Cpsit\CpsDownload\Tests\Unit\Controller;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsDownload\Controller\DownloadController;
use Cpsit\CpsDownload\Domain\Repository\DownloadRepository;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\View\ViewInterface;
use TYPO3\CMS\Extbase\Mvc\ExtbaseRequestParameters;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Page\PageInformation;

class DownloadControllerTest extends TestCase
{
    /**
     * @var array<string, mixed>
     */
    private array $assigned = [];

    public function testConstructorArgumentIsNotNullable(): void
    {
        $constructor = (new \ReflectionClass(DownloadController::class))->getConstructor();

        self::assertNotNull($constructor);
        $parameter = $constructor->getParameters()[0];
        self::assertFalse($parameter->allowsNull());
        self::assertFalse($parameter->isDefaultValueAvailable());
    }

    public function testPrepareViewAssignsNoPageDataWithoutPageInformationAttribute(): void
    {
        $this->prepareView($this->createRequest());

        self::assertArrayHasKey('contentObjectData', $this->assigned);
        self::assertArrayNotHasKey('pageData', $this->assigned);
    }

    public function testPrepareViewAssignsThePageRecordFromThePageInformationAttribute(): void
    {
        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord(['uid' => 5, 'title' => 'Downloads']);

        $this->prepareView($this->createRequest()->withAttribute('frontend.page.information', $pageInformation));

        self::assertSame(['uid' => 5, 'title' => 'Downloads'], $this->assigned['pageData']);
    }

    private function createRequest(): Request
    {
        $contentObject = new ContentObjectRenderer();
        $contentObject->data = ['uid' => 10];

        return (new Request(
            (new ServerRequest())->withAttribute('extbase', new ExtbaseRequestParameters())
        ))->withAttribute('currentContentObject', $contentObject);
    }

    private function prepareView(Request $request): void
    {
        $view = self::createStub(ViewInterface::class);
        $view->method('assign')->willReturnCallback(
            function (string $key, mixed $value) use ($view): ViewInterface {
                $this->assigned[$key] = $value;

                return $view;
            }
        );

        $controller = new DownloadController(self::createStub(DownloadRepository::class));
        $reflection = new \ReflectionClass($controller);
        $reflection->getProperty('request')->setValue($controller, $request);
        $reflection->getProperty('view')->setValue($controller, $view);
        $reflection->getMethod('prepareView')->invoke($controller);
    }
}
