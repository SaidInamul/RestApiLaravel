<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class CustomerFilter extends ApiFilter {

    protected $allowedParms = [
        'postalCode' => ['eq', 'gt', 'lt'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'id' => ['eq', 'gt', 'lt'],
    ];

    protected $columnMap = [
        'postalCode' => 'postal_Code',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'gte' => '=>',
        'lte' => '<=',
        'gt' => '>',
        'lt' => '<',
    ];
}

?>