<?php

namespace Corals\Modules\Medical\Enums;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum PaymentTypes: string
{
    case Cash = 'cash';
    case Visa = 'visa';

    /**
     * Get human-readable label for the status
     */
    public function label(): string
    {
        return match ($this) {
            self::Cash => 'Cash',
            self::Visa => 'Visa / Mastercard',
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
                fn(PaymentTypes $status) => user()?->can(Str::camel($status->name), $model),
            )
        )->mapWithKeys(fn(PaymentTypes $status) => [
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
            self::Cash => 'success',
            self::Visa => 'info',
        };
    }
}