<div>
    <button type="button" class="btn btn-custome" data-bs-toggle="modal"
        data-bs-target="#TenderQuestionModal{{ $tender->id }}">
        الاسئلة
    </button>

    <div class="modal fade" id="TenderQuestionModal{{ $tender->id }}" tabindex="-1"
        aria-labelledby="TenderQuestionModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" style="max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TenderQuestionModalLabel">الاسئلة</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateQuestions({{ $tender->id }})">
                        <div class="mb-3">
                            @foreach ($questions as $question)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $question->id }}"
                                        id="question{{ $question->id }}"
                                        wire:model="selectedQuestions.{{ $tender->id }}">
                                    <h6>{{ $question->title }}</h6>
                                    <small>{{ $question->description }}</small>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-success">تحديث</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
