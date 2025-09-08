<?php

namespace Corals\Modules\Medical\Enums;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum GenderStatus: string
{
    case Male = 'male';
    case Female = 'female';

    /**
     * Get human-readable label for the status
     */
    public function label(): string
    {
        return match ($this) {
            self::Male => 'Male',
            self::Female => 'Female',
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
                fn(genderStatus $status) => user()?->can(Str::camel($status->name), $model),
            )
        )->mapWithKeys(fn(genderStatus $status) => [
            $status->value => $status->label()
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
     * Get Bootstrap color class for the status
     */
    public function color(): string
    {
        return match ($this) {
            self::Male => 'info',
            self::Female => 'warning',
        };
    }
}