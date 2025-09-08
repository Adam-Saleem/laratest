<?php

namespace Corals\Modules\Medical\Enums;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum DurationUnit: string
{
    case Hours = 'hours';
    case Days = 'days';
    case Weeks = 'weeks';
    case Months = 'months';
    case Years = 'years';

    /**
     * Get human-readable label for the unit
     */
    public function label(): string
    {
        return match ($this) {
            self::Hours => 'Hours',
            self::Days => 'Days',
            self::Weeks => 'Weeks',
            self::Months => 'Months',
            self::Years => 'Years',
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
                fn(DurationUnit $unit) => user()?->can(Str::camel($unit->name), $model),
            )
        )->mapWithKeys(fn(DurationUnit $unit) => [
            $unit->value => $unit->label()
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
     * Get Bootstrap color class for the unit
     */
    public function color(): string
    {
        return match ($this) {
            self::Hours => 'info',
            self::Days => 'primary',
            self::Weeks => 'success',
            self::Months => 'warning',
            self::Years => 'secondary',
        };
    }
}