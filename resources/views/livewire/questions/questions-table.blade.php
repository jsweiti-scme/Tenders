<div>
    @include('livewire.questions.add-question-modal')
    <div class="card-body">
        <div class="table-rep-plugin">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>الرقم التعريفي</th>
                            <th>العنوان</th>
                            <th>الوصف</th>
                            <th>نوع السؤال</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{{ $question->id }}</td>
                                <td>{{ $question->title }}</td>
                                <td>{{ $question->description }}</td>
                                <td>
                                    {{$question->Answer->answer_type_ar}}
                                    @if ($question->Answer->answer_type == 'multiple_choice')
                                    <small style="display: block">
                                        @foreach (json_decode($question->answers) as $loopIndex => $answer1)
                                            {{$loopIndex + 1}}. {{$answer1}}
                                        @endforeach                                    
                                    </small>
                                    @endif
                                </td>
                                <td>
                                    <button wire:click="delete({{ $question->id }})"
                                        class="btn btn-danger" wire:confirm="هل انت متأكد من حذف البيانات ؟ لا يمكن استرجاع البيانات المحذوفة">حذف</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{$questions->links()}}
        </div>
    </div>
</div>
