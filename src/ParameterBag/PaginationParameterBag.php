<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\ParameterBag;

use Symfony\Component\HttpFoundation\Request;

final class PaginationParameterBag
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var int
     */
    private $numberOfResults;

    /**
     * @var int
     */
    private $maxPerPage;

    /**
     * @var int
     */
    private $currentPage;

    public function __construct(Request $request, int $numberOfResults, int $maxPerPage, int $currentPage)
    {
        $this->request = $request;
        $this->numberOfResults = $numberOfResults;
        $this->maxPerPage = $maxPerPage;
        $this->currentPage = $currentPage;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getNumberOfResults(): int
    {
        return $this->numberOfResults;
    }

    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }
}
