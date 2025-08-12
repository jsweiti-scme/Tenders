<div>
    @if ($tender->winner_id != null)
    <button type="button" class="btn btn-custome" disabled>
        تم ارساء العطاء
    </button>
    @elseif ($tender->can_apply)
    <button type="button" class="btn btn-custome" data-mdb-toggle="modal" data-mdb-target="#ApplyCompanyModal{{$tender->id}}"  wire:click="setTenderId({{$tender->id}})">
        قدم الان
    </button>
    @else
    <button type="button" class="btn btn-custome" disabled>
        لقد تم التقديم مسبقاً
    </button>
    @endif

    <div class="modal fade" id="ApplyCompanyModal{{$tender->id}}" tabindex="-1" aria-labelledby="ApplyCompanyModalLabel{{$tender->id}}" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ApplyCompanyModalLabel{{$tender->id}}">قدم الان</h5>
                </div>
                <div class="modal-body">
                    <form>
                        @foreach ($tender->Questions as $question)
                        <div class="mb-3">
                            <h6>{{ $question->title }}</h6>
                            <small>{{$question->description}}</small>
                            <div>
                            @if ($question->Answer->answer_type == 'yes_no')
                                <input class="form-check-input" type="radio" wire:model.defer="questionAnswers.{{$question->id}}" name="question_answers_{{$question->id}}" value="صح" >
                                <label class="form-check-label" for="flexRadioDefault1">صح</label>
                                <input class="form-check-input" type="radio" wire:model.defer="questionAnswers.{{$question->id}}" name="question_answers_{{$question->id}}" value="خطأ">
                                <label class="form-check-label" for="flexRadioDefault1">خطأ</label>
                            @elseif ($question->Answer->answer_type == 'multiple_choice')
                                <small style="display: block">
                                    @foreach (json_decode($question->answers) as $loopIndex => $answer)
                                    <input class="form-check-input" type="radio" wire:model.defer="questionAnswers.{{$question->id}}" name="question_answers_{{$question->id}}" value="{{$answer}}">
                                    <label class="form-check-label" for="flexRadioDefault1">{{$answer}}</label>
                                    @endforeach
                                </small>
                            @elseif ($question->Answer->answer_type == 'text')
                                <textarea wire:model.defer="questionAnswers.{{$question->id}}" name="question_answers_{{$question->id}}" id="" cols="30" rows="10"></textarea>
                            @elseif ($question->Answer->answer_type == 'file')
                                <input type="file" wire:model.defer="questionAnswers.{{$question->id}}" name="question_answers_{{$question->id}}" accept=".pdf,image/jpeg,image/jpg,image/png">
                                <small style="display: block">الصيغ المقبولة : pdf, jpeg , jpg , png</small>
                                <small style="display: block">الحجم الاقصى : 1MB</small>
                            @endif
                            </div>
                            <hr>
                        </div>
                        @endforeach
                        <button type="submit" class="btn btn-success" onclick="confirmSubmission(event)">تقديم</button>
                        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">إغلاق</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    function confirmSubmission(event) {
        event.preventDefault();
        swal({
            title: "تأكيد",
            text: "هل انت متأكد من جميع المعلومات ؟ لا يمكن تعديل او الغاء تقديم هذه المعلومات فيما بعد",
            icon: "warning",
            buttons: {
                cancel: "إلغاء",
                confirm: {
                    text: "تأكيد",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true
                }
            },
            dangerMode: true,
        })
        .then((willSubmit) => {
            if (willSubmit) {
                @this.call('ApplyTender');
            }
        });
    }

</script>