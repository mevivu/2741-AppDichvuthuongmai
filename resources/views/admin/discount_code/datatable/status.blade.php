<span @class([ 'badge' , 'bg-green-lt'=> \App\Enums\DiscountCode\DiscountCodeStatus::Activities == $status,
    'bg-info-lt' => \App\Enums\DiscountCode\DiscountCodeStatus::NotActivated == $status,
    'bg-yellow-lt' => \App\Enums\DiscountCode\DiscountCodeStatus::Used == $status,
    'bg-danger-lt' => \App\Enums\DiscountCode\DiscountCodeStatus::Expired == $status,
    'bg-info-lt' => \App\Enums\DiscountCode\DiscountCodeStatus::ConditionsNotMet == $status,
    'bg-lime-lt' => \App\Enums\DiscountCode\DiscountCodeStatus::UsageLimits == $status,
    ])>{{ \App\Enums\DiscountCode\DiscountCodeStatus::getDescription($status) }}</span>
