<?php

namespace Corals\Modules\Medical\Enums;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum VisitStatuses: string
{
    case Scheduled = 'scheduled';
    case Waiting = 'waiting';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case NoShow = 'no_show';

    /**
     * Get human-readable label for the status
     */
    public function label(): string
    {
        return match ($this) {
            self::Scheduled => 'Scheduled',
            self::Waiting => 'Waiting',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::NoShow => 'No Show',
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
                fn(VisitStatuses $status) => user()?->can(Str::camel($status->name), $model),
            )
        )->mapWithKeys(fn(VisitStatuses $status) => [
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
            self::Scheduled => 'primary',
            self::Waiting => 'info',
            self::InProgress => 'warning',
            self::Completed => 'success',
            self::Cancelled => 'danger',
            self::NoShow => 'secondary',
        };
    }
}