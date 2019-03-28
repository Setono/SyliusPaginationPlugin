<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\EventListener;

use Fig\Link\GenericLinkProvider;
use Fig\Link\Link;
use Psr\Link\EvolvableLinkProviderInterface;
use Setono\SyliusPaginationPlugin\EventHandler\EventHandlerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Webmozart\Assert\Assert;

final class AddPaginationLinksListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EventHandlerInterface
     */
    private $eventHandler;

    /**
     * @var string
     */
    private $pageParameter;

    public function __construct(RequestStack $requestStack, EventHandlerInterface $eventHandler, string $pageParameter)
    {
        $this->requestStack = $requestStack;
        $this->eventHandler = $eventHandler;
        $this->pageParameter = $pageParameter;
    }

    public function handle(Event $event): void
    {
        if (!$this->eventHandler->supports($event)) {
            return;
        }

        $paginationParameters = $this->eventHandler->handle($event);

        $request = $paginationParameters->getRequest();

        // do not add prev/next links to ajax requests
        if ($request->isXmlHttpRequest()) {
            return;
        }

        // only add prev/next links if the request is the master request
        if ($request !== $this->requestStack->getMasterRequest()) {
            return;
        }

        $numberOfResults = $paginationParameters->getNumberOfResults();
        $pages = ceil($numberOfResults / $paginationParameters->getMaxPerPage());

        $links = [];

        // prev link
        if ($paginationParameters->getCurrentPage() > 1) {
            $links[] = new Link('prev', $this->getPageUrl($request, $paginationParameters->getCurrentPage() - 1));
        }

        // next link
        if ($paginationParameters->getCurrentPage() < $pages) {
            $links[] = new Link('next', $this->getPageUrl($request, $paginationParameters->getCurrentPage() + 1));
        }

        if (count($links) > 0) {
            /** @var EvolvableLinkProviderInterface $linkProvider */
            $linkProvider = $request->attributes->get('_links', new GenericLinkProvider());

            foreach ($links as $link) {
                $linkProvider = $linkProvider->withLink($link);
            }

            $request->attributes->set('_links', $linkProvider);
        }
    }

    private function getPageUrl(Request $request, int $page): string
    {
        Assert::greaterThan($page, 0);

        $components = parse_url($request->getUri());

        $uri = $components['scheme'] . '://' . $components['host'];
        if (array_key_exists('port', $components)) {
            $uri .= $components['port'];
        }
        if (array_key_exists('path', $components)) {
            $uri .= $components['path'];
        }

        $queryComponents = [];
        if (array_key_exists('query', $components)) {
            parse_str($components['query'], $queryComponents);
        }

        if (1 === $page) {
            // strip page parameter
            unset($queryComponents[$this->pageParameter]);
        } else {
            $queryComponents[$this->pageParameter] = $page;
        }

        if (count($queryComponents) > 0) {
            $uri .= '?' . http_build_query($queryComponents, '', '&', PHP_QUERY_RFC3986);
        }

        return $uri;
    }
}
