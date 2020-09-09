<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 *
 * This class is based on the Paysafe Pay Later OpenAPI specification, version 1.0.0.
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Model;

// phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
// phpcs:disable ObjectCalisthenics.Metrics.PropertyPerClassLimit

class Contract
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var DocumentType|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @param string|null $name
     * @param DocumentType|null $type
     * @param string|null $id
     * @param string|null $url
     */
    public function __construct(
        string $name = null,
        DocumentType $type = null,
        string $id = null,
        string $url = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->id = $id;
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Contract
     */
    public function setName(string $name): Contract
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DocumentType|null
     */
    public function getType(): ?DocumentType
    {
        return $this->type;
    }

    /**
     * @param DocumentType $type
     * @return Contract
     */
    public function setType(DocumentType $type): Contract
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Contract
     */
    public function setId(string $id): Contract
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Contract
     */
    public function setUrl(string $url): Contract
    {
        $this->url = $url;
        return $this;
    }
}
