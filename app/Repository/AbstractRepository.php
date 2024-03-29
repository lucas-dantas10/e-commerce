<?php

declare(strict_types=1);

namespace App\Repository;

use App\Interfaces\RepositoryInterface;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    protected static $model;

    public static function loadModel(): Model
    {
        return app(static::$model);
    }

    public static function all(): Collection
    {
        return self::loadModel()::all();
    }

    public static function create(array $attributes, ?array $values): Model|null|static
    {
        return self::loadModel()::query()->firstOrCreate($attributes, $values);
    }

    public static function find(int $id): ?Model
    {
        return self::loadModel()::query()->findOrFail($id);
    }

    public static function delete(int $id): int
    {
        if (static::$model == Customer::class) {
            return self::loadModel()::query()->where('user_id', $id)->delete();
        }

        return self::loadModel()::query()->where('id', $id)->delete();
    }

    public static function update(int $id, array $attributes): int
    {
        if (static::$model == Customer::class) {
            return self::loadModel()::query()->where(['user_id' => $id])->update($attributes);
        }

        return self::loadModel()::query()->where(['id' => $id])->update($attributes);
    }
}
