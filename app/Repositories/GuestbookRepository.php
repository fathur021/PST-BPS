<?php
namespace App\Repositories;

use App\Models\GuestBook;
use App\Repositories\Interface\GuestbookRepositoryInterface;

class GuestbookRepository implements GuestbookRepositoryInterface
{
    public function all()
    {
        return GuestBook::all();
    }

    public function create(array $data)
    {
        return GuestBook::create($data);
    }

    public function update($id, array $data)
    {
        $guestbook = GuestBook::findOrFail($id);
        $guestbook->update($data);
        return $guestbook;
    }

    public function delete($id)
    {
        return GuestBook::destroy($id);
    }

    public function find($id)
    {
        return GuestBook::findOrFail($id);
    }

    public function accept($id, $userId)
    {
        $guestbook = GuestBook::findOrFail($id);
        $guestbook->update([
            'status' => 'inProgress',
            'petugas_pst' => $userId,
            'in_progress_at' => now(),
        ]);
        return $guestbook;
    }
}
