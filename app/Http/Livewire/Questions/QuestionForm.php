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

    public array $questionOptions = [];

    public function mount(Question $question)
    {
        $this->question = $question;

        if ($this->question->exists) {

            $this->editing = true;

            foreach ($this->question->questionOptions as $option) {
                $this->questionOptions[] = [
                    'id' => $option->id,
                    'option' => $option->option,
                    'correct' => $option->correct,
                ];
            }
        }
    }

    public function addQuestionsOption(): void
    {
        $this->questionOptions[] = [
            'option' => '',
            'correct' => false
        ];
    }

    public function removeQuestionsOption(int $index): void
    {
        unset($this->questionOptions[$index]);
        $this->questionOptions = array_values(($this->questionOptions));
    }

    public function save()
    {
        $this->validate();

        $this->question->save();

        $this->question->questionOptions()->delete();

        foreach ($this->questionOptions as $option) {
            $this->question->questionOptions()->create($option);
        }

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
            ],
            'questionOptions' => [
                'required', 'array'
            ],
            'questionOptions.*option' => [
                'required', 'string'
            ]
        ];
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.questions.question-form');
    }
}
