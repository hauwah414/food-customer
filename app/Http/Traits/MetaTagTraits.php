<?php

namespace App\Http\Traits;

use Butschster\Head\Facades\Meta;

/**
 * 
 */
trait MetaTagTraits
{
    public function metaTagLoad($data)
    {
        $altTitle = $data['alt_title'] ?? $data['title'];
        $title = $data['title'];
        $description = $data['description'] ?? 'ss';
        $keywords = $data['keywords'] ?? 'sa';
        $featuredImage = $data['featured_image'];
        $canonicalUrl = $data['canonical_url'];

        Meta::setCharset()
            ->setTitle($title)
            ->prependTitle($altTitle)
            ->setTitleSeparator('|')
            ->setDescription($description)
            ->setKeywords($keywords)
            ->setCanonical($canonicalUrl)
            ->setViewport('width=device-width, initial-scale=1')
            ->setContentType('text/html');

        if (isset($data['robots']) && !empty($data['robots'])) {
            Meta::setRobots($data['robots']);
        }
    }
}
