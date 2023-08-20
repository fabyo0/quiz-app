<?php

namespace App\Http\Livewire\Questions;

use App\Models\Question;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class QuestionList extends Component
{
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $questions = Question::latest()->paginate(7);

        return view('livewire.questions.question-list', [
            'questions' => $questions
        ]);
    }

    public function delete(Question $question): void
    {
        abort_if(!auth()->user() && auth()->user()->is_admin, Response::HTTP_FORBIDDEN, '403 Forbidden');
        $question->delete();
    }
}
