<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;

class CustomerFilter {

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
        'lt' => '<'
    ];

    public function transform (Request $request) {
        $eloQuery = [];

        foreach($this->allowedParms as $parms => $operators) {
            $query = $request->query($parms);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parms] ?? $parms;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}

?>