<?php

namespace CodeFlix\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository
 * @package namespace CodeFlix\Repositories;
 */
interface UserRepository extends RepositoryInterface
{
    //
    public function create(array $attributes);
    public function update(array $attributes, $id);
}
