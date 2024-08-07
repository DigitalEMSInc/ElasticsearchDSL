<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CustomNormalizer;

/**
 * Normalizer used with referenced normalized objects.
 */
class CustomReferencedNormalizer extends CustomNormalizer
{
    /**
     * @var array
     */
    private $references = [];
    
    
    // delete this removing the 'implements CacheableSupportsMethodInterface'
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $object->setReferences($this->references);
        $data = parent::normalize($object, $format, $context);
        $this->references = array_merge($this->references, $object->getReferences());

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof AbstractNormalizable;
    }
}
