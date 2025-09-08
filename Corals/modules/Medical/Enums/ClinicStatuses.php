<?php

namespace Corals\Modules\Medical\Enums;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum ClinicStatuses: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Suspended = 'suspended';

    /**
     * Get human-readable label for the status
     */
    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Suspended => 'Suspended',
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
                fn(ClinicStatuses $status) => user()?->can(Str::camel($status->name), $model),
            )
        )->mapWithKeys(fn(ClinicStatuses $status) => [
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
            self::Active => 'success',
            self::Inactive => 'secondary',
            self::Suspended => 'danger',
        };
    }
}