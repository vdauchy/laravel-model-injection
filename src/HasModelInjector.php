<?php
declare(strict_types=1);

namespace VDauchy\ModelInjector;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

trait HasModelInjector
{
    private static array $resolvedModels = [];

    /**
     * @param string $model
     * @return Builder
     */
    protected function mQuery(string $model): Builder
    {
        return $this->mNew($model)->newQuery();
    }

    /**
     * @param string $model
     * @param array $attributes
     * @return Model
     */
    protected function mNew(string $model, array $attributes = []): Model
    {
        return $this->resolve($model)->newInstance($attributes);
    }

    /**
     * @param string $model
     * @return string
     */
    protected function mClass(string $model): string
    {
        return get_class($this->resolve($model));
    }

    /**
     * @param string $model
     * @return string
     */
    protected function mTable(string $model): string
    {
        return $this->resolve($model)->getTable();
    }

    /**
     * @param string $model
     * @return Collection
     */
    protected function mColumns(string $model): Collection
    {
        return collect(Schema::getColumnListing($this->mTable($model)));
    }

    /**
     * @param string $model
     * @return Model
     */
    private function resolve(string $model): Model
    {
        return static::$resolvedModels[$model] ??= App::make($model);
    }
}