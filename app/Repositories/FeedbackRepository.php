<?php
namespace App\Repositories;

use App\Models\Feedback;
use App\Repositories\Interface\FeedbackRepositoryInterface;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    public function all()
    {
        return Feedback::all();
    }

    public function create(array $data)
    {
        return Feedback::create($data);
    }

    public function update($id, array $data)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update($data);
        return $feedback;
    }

    public function delete($id)
    {
        return Feedback::destroy($id);
    }

    public function find($id)
    {
        return Feedback::findOrFail($id);
    }
}
