<?php 

namespace Symfony\UX\DataTables\Model;

class DataTable
{


    private array $options = [];
    private array $attributes = [];

    public function __construct(
        private readonly ?string $id = null,
    )
    {}

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getDataController(): ?string
    {
        return $this->attributes['data_controller'] ?? null;
    }

}