<?php

declare(strict_types=1);

namespace Frontend\Plugin;

use Frontend\Slug\SlugInterface;
use Mezzio\Helper\UrlHelper;

/**
 * Class UrlHelperPlugin
 * @package Frontend\Plugin
 */
class UrlHelperPlugin implements PluginInterface
{
    protected UrlHelper $urlHelper;
    private SlugInterface $slugAdapter;

    /**
     * UrlHelperPlugin constructor.
     * @param UrlHelper $helper
     * @param SlugInterface $slugAdapter
     */
    public function __construct(UrlHelper $helper, SlugInterface $slugAdapter)
    {
        $this->urlHelper = $helper;
        $this->slugAdapter = $slugAdapter;
    }

    /**
     * @param string|null $routeName
     * @param array $routeParams
     * @param array $queryParams
     * @param null $fragmentIdentifier
     * @param array $options
     * @return UrlHelperPlugin|string
     */
    public function __invoke(
        string $routeName = null,
        array $routeParams = [],
        $queryParams = [],
        $fragmentIdentifier = null,
        array $options = []
    ) {
        $args = func_get_args();
        if (empty($args)) {
            return $this;
        }

        return $this->generate($routeName, $routeParams, $queryParams, $fragmentIdentifier, $options);
    }

    /**
     * @param string|null $routeName
     * @param array $routeParams
     * @param array $queryParams
     * @param null $fragmentIdentifier
     * @param array $options
     * @return string
     */
    public function generate(
        string $routeName = null,
        array $routeParams = [],
        $queryParams = [],
        $fragmentIdentifier = null,
        array $options = []
    ): string {

        $response = $this->slugAdapter->match($routeName, $routeParams, $queryParams, $fragmentIdentifier, $options);

        if ($response->isSuccess()) {
            return $response->getUrl();
        }

        return $this->urlHelper->generate($routeName, $routeParams, $queryParams, $fragmentIdentifier, $options);
    }
}
