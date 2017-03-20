<?php
namespace Portrino\PxSemanticExample\Processor;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Andre Wuttig <wuttig@portrino.de>, portrino GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use GeorgRinger\News\Domain\Model\News;
use Portrino\PxSemantic\Processor\AbstractProcessor;
use Portrino\PxSemantic\SchemaOrg\ImageObject;
use Portrino\PxSemantic\SchemaOrg\NewsArticle;
use Portrino\PxSemantic\SchemaOrg\Person;
use Portrino\PxSemantic\SchemaOrg\Thing;
use TYPO3\CMS\Core\Resource\AbstractFile;

/**
 * Class NewsProcessor
 *
 * @package Portrino\PxSemantic\Processor
 */
class NewsProcessor extends AbstractProcessor
{
    /**
     * @var \GeorgRinger\News\Domain\Repository\NewsRepository
     * @inject
     */
    protected $newsRepository;

    /**
     *  Initializes the processor before invoking the process method
     *
     * @return void
     */
    public function initializeObject()
    {
        parent::initializeObject();
    }

    /**
     * @param Thing $entity
     * @param array $settings
     * @param int|null $resourceId
     */
    public function process(&$entity, $settings = [], $resourceId = null)
    {
        if ($resourceId != null) {
            /** @var News $news */
            $news = $this->newsRepository->findByUid((int)$resourceId);

            if ($news && $entity instanceof NewsArticle) {

                $url = $this->uriBuilder
                    ->setTargetPageUid($settings['detailPid'])
                    ->setUseCacheHash(true)
                    ->uriFor(
                        'detail',
                        [
                            'news' => $news->getUid()
                        ],
                        'News',
                        'News',
                        'Pi1'
                    );

                $entity->setId($url);

                // set the name to the navTitle / title of the page
                $name = $news->getTitle() ? $news->getTitle() : $news->getAlternativeTitle();
                if ($name != '') {
                    $entity->setName($name);
                }

                // set the headline to the title of the page
                $entity->setHeadline($news->getTitle());

                /**
                 * set the url
                 */
                $entity->setUrl($url);
                $entity->setMainEntityOfPage($url);

                $datePublished = $news->getDatetime();
                if (!$datePublished) {
                    $datePublished = new \DateTime();
                    $datePublished->setTimestamp($news->getCrdate());
                }
                $entity->setDatePublished($datePublished);


                if ($news->getTstamp() instanceof \DateTime) {
                    $dateModified = $news->getTstamp();
                    $entity->setDateModified($dateModified);
                }

                $description = $news->getTeaser();
                if ($description != '') {
                    $entity->setDescription($description);
                }

                if ($news->getAuthor() != '') {
                    /**
                     * set the author to the author of the page if it is set
                     *
                     * @var Person $author
                     */
                    $author = $this->objectManager->get(Person::class);
                    $author->setName($news->getAuthor());
                    $entity->setAuthor($author);
                }

                // set the image to the first image into resources/media list of the page
                $media = $news->getFalMedia();
                if ($media != null && $media->count() > 0) {
                    /** @var \TYPO3\CMS\Extbase\Domain\Model\FileReference $image */
                    $image = $media->toArray()[0];
                    if ($image->getOriginalResource()->getType() === AbstractFile::FILETYPE_IMAGE) {
                        $image = $this->imageService->getImage('', $image, true);

                        $width = $settings['media']['width'] ? (int)$settings['media']['width'] : 696;
                        $height = $settings['media']['height'] ? (int)$settings['media']['height'] : 'auto';

                        $processingInstructions = [
                            'width' => $width,
                            'height' => $height,
                        ];

                        $processedImage = $this->imageService->applyProcessingInstructions($image, $processingInstructions);

                        if ($processedImage) {
                            /** @var ImageObject $imageObject */
                            $imageObject = $this->objectManager->get(ImageObject::class);

                            $imageObject->setWidth((int)$processedImage->getProperty('width'));
                            $imageObject->setHeight((int)$processedImage->getProperty('height'));
                            $imageObject->setUrl($this->imageService->getImageUri($processedImage));

                            $entity->setImage($imageObject);
                        }
                    }
                }
            }
        }
    }
}