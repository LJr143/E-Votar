<?php

namespace App\Livewire\Feedback;

use App\Models\Feedback;
use Livewire\Component;
use Livewire\WithPagination;

class FeedbackTable extends Component
{
    use WithPagination;

    public $dateFilter = '';
    public $ratingFilter = '';

    protected $queryString = [
        'dateFilter' => ['except' => ''],
        'ratingFilter' => ['except' => '']
    ];

    public function render()
    {
        $reviews = Feedback::query()
            ->when($this->dateFilter, function ($query) {
                return $query->whereDate('created_at', $this->dateFilter);
            })
            ->when($this->ratingFilter, function ($query) {
                return $query->where('rating', '>=', $this->ratingFilter);
            })
            ->latest()
            ->paginate(5);

        return view('evotar.livewire.feedback.feedback-table', [
            'reviews' => $reviews,
            'totalReviews' => Feedback::count()
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['dateFilter', 'ratingFilter']);
    }

}
