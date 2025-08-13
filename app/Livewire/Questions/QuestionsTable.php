<?php

namespace App\Livewire\Questions;

use App\Models\AnswerType;
use App\Models\Question;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class QuestionsTable extends Component
{
    use LivewireAlert;

    public $newQuestion = [
        'title' => '',
        'description' => '',
        'answer_type' => null,
        'answers' => [],
    ];

    public $answerInput = '';
    public function index()
    {
        return view('livewire.questions.index');
    }

    public function render()
    {
        $questions = Question::paginate(20);
        $answersType = AnswerType::all();

        return view('livewire.questions.questions-table', compact('questions', 'answersType'));
    }

    public function create()
    {
        $this->validate([
            'newQuestion.title' => 'required|string|max:255',
            'newQuestion.description' => 'required|string',
            'newQuestion.answer_type' => 'required|string',
        ]);

        $newQuestion = new Question;
        $newQuestion->title = $this->newQuestion['title'];
        $newQuestion->description = $this->newQuestion['description'];
        $answer_type_id = AnswerType::where('answer_type', $this->newQuestion['answer_type'])->pluck('id')->first();


        if ($this->newQuestion['answer_type'] === 'multiple_choice') {
            $newQuestion->answers = json_encode($this->newQuestion['answers']);
        } else {
            $newQuestion->answers = null;
        }

        $newQuestion->answer_type_id = $answer_type_id;
        $newQuestion->save();

        $this->reset(['newQuestion', 'answerInput']);

        $this->alert('success', trans('translation.add_success'));
    }

    public function addAnswer()
    {
        if (!empty($this->answerInput)) {
            $this->newQuestion['answers'][] = $this->answerInput;
            $this->answerInput = '';
        }
    }

    public function removeAnswer($index)
    {
        unset($this->newQuestion['answers'][$index]);
        $this->newQuestion['answers'] = array_values($this->newQuestion['answers']);
    }

    public function updatedNewQuestionAnswerType($value)
    {
        $this->newQuestion['answer_type'] = $value;
        if ($value !== 'multiple_choice') {
            $this->newQuestion['answers'] = [];
        }
    }
    public function delete($id)
    {
        $question = Question::find($id);
        $question->delete();
        $this->alert('success', 'تم حذف السؤال بنجاح');
    }
}
