<?php

namespace App\Repositories\Interface;

interface GuestbookRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function find($id);
    public function accept($id, $userId);
}

