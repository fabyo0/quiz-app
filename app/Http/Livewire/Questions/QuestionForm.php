<?php

namespace App\Http\Livewire\Questions;

use App\Models\Question;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class QuestionForm extends Component
{
    public Question $question;

    public bool $editing = false;

    public function mount(Question $question)
    {
        $this->question = $question;

        if ($this->question->exists) {
            $this->editing = true;
        }
    }

    public function save()
    {
        $this->validate();

        $this->question->save();

        return Redirect::route('questions');
    }

    protected function rules(): array
    {
        return [
            'question.question_text' => ['required', 'string'],
            'question.code_snippet' => [
                'string', 'required'
            ],
            'question.answer_explanation' => [
                'required', 'string'
            ],
            'question.more_info_link' => [
                'required', 'string'
            ]
        ];
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.questions.question-form');
    }
}
