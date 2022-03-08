<?php
namespace App\Services;

use App\Models\LoanSetting;

class LoanSettingsService {

    protected $loanSettingsDetails;

    /**
     * Get Kredi Loan default details
     */
    public function __construct()
    {
        $this->loanSettingsDetails = LoanSetting::first();
       return $this;
    }

    public function getDefaultLoanDetails()
    {
        return $this->loanSettingsDetails;
    }
}