<div>
    <button type="button" class="btn btn-custome" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
        إضافة سؤال
    </button>

    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionModalLabel">إضافة سؤال</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="create">
                        <div class="mb-3">
                            <label for="title" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="title" wire:model="newQuestion.title" required>
                            @error('newQuestion.title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control" id="description" wire:model="newQuestion.description" required></textarea>
                            @error('newQuestion.description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="answer_type" class="form-label">نوع السؤال</label>
                            <select class="form-select" id="answer_type" wire:model="newQuestion.answer_type" required>
                                <option value="null" selected>غير محدد</option>
                                @foreach ($answersType as $answerType)
                                    <option value="{{$answerType->answer_type}}">{{$answerType->answer_type_ar}}</option>
                                @endforeach

                            </select>
                            @error('newQuestion.answer_type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div  @if(count($newQuestion['answers']) == 0) id="answersInputDiv" @endif class="mb-3" style="display: block;">
                            <label for="answers" class="form-label">إجابات</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" wire:model="answerInput">
                                <button type="button" class="btn btn-secondary" wire:click="addAnswer">إضافة</button>
                            </div>
                            @foreach ($newQuestion['answers'] as $index => $answer)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" value="{{ $answer }}" readonly>
                                    <button type="button" class="btn btn-danger" wire:click="removeAnswer({{ $index }})">حذف</button>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-success">إضافة</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const answerTypeSelect = document.getElementById('answer_type');
        const answersInputDiv = document.getElementById('answersInputDiv');

        function updateAnswersInputDiv() {
            if (answerTypeSelect.value === 'multiple_choice' || @json($newQuestion['answers']).length > 0) {
                answersInputDiv.style.display = 'block';
            } else {
                answersInputDiv.style.display = 'none';
            }
        }
        answerTypeSelect.addEventListener('change', updateAnswersInputDiv);
        // Trigger the change event to set the initial state
        answerTypeSelect.dispatchEvent(new Event('change'));
        // Listen for Livewire updates to re-trigger the change event
        Livewire.hook('message.processed', (message, component) => {
            updateAnswersInputDiv();
        });
    });
</script>
