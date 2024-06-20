<?php

namespace App\Admin\Rules\Transaction;

use App\Models\DriverTransaction;
use Illuminate\Contracts\Validation\Rule;

class MatchSystemRevenue implements Rule
{
    private $transactionId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $transaction = DriverTransaction::with('order')->find($this->transactionId);
        return $transaction && $transaction->order && $value == $transaction->order->system_revenue;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('invalid_transfer_amount');
    }
}
