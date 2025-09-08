<?php

namespace Corals\Modules\Medical\Enums;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum PrescriptionsTypes: string
{
    case Normal = 'normal';
    case Red = 'red';

    /**
     * Get human-readable label for the type
     */
    public function label(): string
    {
        return match ($this) {
            self::Normal => 'Normal',
            self::Red => 'Red',
        };
    }

    /**
     * @param Model $model
     * @param bool $skipPolicy
     * @return array
     */
    public static function options(Model $model = null, bool $skipPolicy = false): array
    {
        return collect(self::cases())->unless(
            $skipPolicy,
            fn(Collection $statues) => $statues->filter(
                fn(PrescriptionsTypes $type) => user()?->can(Str::camel($type->name), $model),
            )
        )->mapWithKeys(fn(PrescriptionsTypes $type) => [
            $type->value => $type->label()
        ])->toArray();
    }

    /**
     * Get status badge HTML with Bootstrap classes
     */
    public function badge(): string
    {
        return sprintf(
            '<span class="label label-%s">%s</span>',
            $this->color(),
            $this->label()
        );
    }

    /**
     * Get Bootstrap color class for the type
     */
    public function color(): string
    {
        return match ($this) {
            self::Normal => 'primary',
            self::Red => 'danger',
        };
    }
}