<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;

abstract class ApiResponse implements Arrayable
{
    /**
     * Response Data
     */
    protected array $data;

    /**
     * ApiResponse constructor.
     * @param array $data
     */
    public function __construct(?array $data = null)
    {
        $this->data = $data ?? [];
    }

    /**
     * Get Data Value
     * @param string $field
     * @param null $fallback
     * @return array|string|float|int|bool
     */
    public function get(string $field, $fallback = null)
    {
        return data_get($this->data, $field, $fallback);
    }

    /**
     * Get Property as Collection
     * @param string $field
     * @return Collection
     */
    public function collect(string $field): Collection
    {
        return Collection::make($this->get($field, []));
    }

    /**
     * Get the data as an array.
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
