<?php
declare(strict_types=1);

namespace App\Message\Account\Application\Query\ViewModel;

class AccountTransformer
{
    public function transform(array $data): AccountViewModel
    {
        return new AccountViewModel(
            (string) $data['id'],
            $data['name.name']
        );
    }

    public function transformMultiple(array $accounts): array
    {
        return array_map(fn (array $account) => $this->transform($account), $accounts);
    }
}