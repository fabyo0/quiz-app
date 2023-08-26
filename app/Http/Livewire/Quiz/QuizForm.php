<?php

namespace App\Http\Livewire\Quiz;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Livewire\Component;

class QuizForm extends Component
{
    public Quiz $quiz;

    public array $questions = [];

    public bool $editing = false;

    public array $listsForFields = [];

    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz;

        $this->initListsForFields();

        $this->questions = $this->quiz->questions()->pluck('questions.id')->toArray();

        if ($this->quiz->exists) {
            $this->editing = true;
        } else {
            $this->quiz->published = false;
            $this->quiz->public = false;
        }
    }

    public function updatedQuizTitle(): void
    {
        $this->quiz->slug = Str::slug($this->quiz->title);
    }

    public function save()
    {
        $this->validate();
        $this->quiz->save();

        $this->quiz->questions()->sync($this->questions);

        return Redirect::route('quizzes');
    }

    public function render()
    {
        return view('livewire.quiz.quiz-form');
    }

    protected function rules(): array
    {
        return [
            'quiz.title' => [
                'string',
                'required',
            ],
            'quiz.slug' => [
                'string',
                'nullable',
            ],
            'quiz.description' => [
                'string',
                'nullable',
            ],
            'quiz.published' => [
                'boolean',
            ],
            'quiz.public' => [
                'boolean',
            ],
        ];
    }

    protected function initListsForFields()
    {
        $this->listsForFields['questions'] = Question::query()->pluck('question_text', 'id')->toArray();
    }
}
