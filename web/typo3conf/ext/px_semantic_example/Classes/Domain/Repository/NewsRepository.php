<?php
namespace Portrino\PxSemanticExample\Domain\Repository;

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
use Portrino\PxSemantic\Domain\Repository\RestRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class NewsRepository
 * @package Portrino\PxSemanticExample\Domain\Repository
 */
class NewsRepository extends \GeorgRinger\News\Domain\Repository\NewsRepository implements RestRepositoryInterface
{
    /**
     * @var array $defaultOrderings
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING
    ];

    /**
     * Returns all objects of this repository limited by offset and limit and constraint
     *
     * @param int $offset
     * @param int $limit
     * @param string $constraint
     *
     * @return QueryResultInterface|array
     */
    public function findByOffsetAndLimitAndConstraint($offset = 0, $limit = -1, $constraint = '')
    {
        $query = $this->createQuery();

        if ($offset > 0) {
            $query->setOffset($offset);
        }

        if ($limit > -1) {
            $query->setLimit($limit);
        }

        return $query->execute();
    }

    /**
     * Count by constraint
     *
     * @param string $constraint
     *
     * @return int
     */
    public function countByConstraint($constraint = '')
    {
        // we call countAll here, because we have no specific contraints
        return parent::countAll();
    }
}
