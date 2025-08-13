<div>
    @if ($tender->winner_id != null)
        <button type="button" class="btn btn-secondary" disabled>
            تم ارساء العطاء
        </button>
    @elseif ($tender->can_apply)
        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#applyTenderItemsModal"
            wire:click="setTenderId({{ $tender->id }})">
            قدم الان
        </button>
    @else
        <button type="button" class="btn btn-secondary" disabled>
            لقد تم التقديم مسبقاً
        </button>
    @endif

    <div class="modal fade" id="applyTenderItemsModal" tabindex="-1" aria-labelledby="applyTenderItemsModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyTenderItemsModalLabel">التقدم للعطاء - اختيار البنود والأسعار</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="ApplyTenderWithItems">

                        @if ($currentTender)
                            <div class="alert alert-light mb-4 border">
                                <h6 class="fw-bold mb-2">{{ $currentTender->title }}</h6>
                                <p class="mb-1"><strong>الوصف:</strong> {{ $currentTender->description }}</p>
                                <p class="mb-1"><strong>تاريخ انتهاء التقديم:</strong>
                                    {{ $currentTender->end_date->format('Y-m-d H:i') }}</p>
                            </div>
                        @endif

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">بنود العطاء المتاحة</h6>

                            @if ($tenderItems && count($tenderItems) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">اختيار</th>
                                                <th>اسم البند</th>
                                                <th>الوصف</th>
                                                <th>وحدة القياس</th>
                                                <th>الكمية المطلوبة</th>
                                                <th>سعر الوحدة</th>
                                                <th>الإجمالي</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tenderItems as $index => $tenderItem)
                                                <tr
                                                    class="{{ isset($selectedTenderItems[$tenderItem['id']]) ? 'table-success' : '' }}">
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                value="{{ $tenderItem['id'] }}"
                                                                wire:model="selectedTenderItems.{{ $tenderItem['id'] }}.selected"
                                                                wire:change="toggleTenderItem({{ $tenderItem['id'] }})">
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold">{{ $tenderItem['name'] }}</td>
                                                    <td>{{ $tenderItem['description'] ?: 'لا يوجد وصف' }}</td>
                                                    <td><span class="badge bg-info">{{ $tenderItem['unit'] }}</span>
                                                    </td>

                                                    <td><span
                                                            class="badge bg-light">{{ number_format($tenderItem['quantity'], 2) }}</span>
                                                    </td>
                                                    <td>
                                                        @if (isset($selectedTenderItems[$tenderItem['id']]['selected']) && $selectedTenderItems[$tenderItem['id']]['selected'])
                                                            <input type="number" step="0.01" min="0.01"
                                                                class="form-control form-control-sm"
                                                                wire:model="selectedTenderItems.{{ $tenderItem['id'] }}.price"
                                                                wire:keyup="calculateTotal({{ $tenderItem['id'] }})"
                                                                placeholder="أدخل السعر" required>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($selectedTenderItems[$tenderItem['id']]['selected']) && $selectedTenderItems[$tenderItem['id']]['selected'])
                                                            <span class="fw-bold text-dark">
                                                                {{ number_format(
                                                                    (is_numeric($selectedTenderItems[$tenderItem['id']]['price'] ?? null)
                                                                        ? (float) $selectedTenderItems[$tenderItem['id']]['price']
                                                                        : 0) * (is_numeric($tenderItem['quantity']) ? (float) $tenderItem['quantity'] : 0),
                                                                    2,
                                                                ) }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title">إجمالي العرض</h6>
                                                <h4 class="text-dark mb-0">{{ number_format($totalBidAmount, 2) }}</h4>
                                                <small class="text-muted">للبنود المحددة</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-light text-center border">
                                    لا توجد بنود متاحة لهذا العطاء
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">الأسئلة الإضافية</h6>
                            @if ($currentTender && $currentTenderQuestions && count($currentTenderQuestions) > 0)
                                @foreach ($currentTenderQuestions as $question)
                                    <div class="mb-3">
                                        <h6>{{ $question['title'] }}</h6>
                                        <small>{{ $question['description'] }}</small>
                                        <div>
                                            @if (isset($question['answer']) && $question['answer']['answer_type'] == 'yes_no')
                                                <input class="form-check-input" type="radio"
                                                    wire:model.defer="questionAnswers.{{ $question['id'] }}"
                                                    name="question_answers_{{ $question['id'] }}" value="صح">
                                                <label class="form-check-label">صح</label>
                                                <input class="form-check-input" type="radio"
                                                    wire:model.defer="questionAnswers.{{ $question['id'] }}"
                                                    name="question_answers_{{ $question['id'] }}" value="خطأ">
                                                <label class="form-check-label">خطأ</label>
                                            @elseif (isset($question['answer']) && $question['answer']['answer_type'] == 'multiple_choice')
                                                <small style="display: block">
                                                    @foreach (json_decode($question['answers']) as $loopIndex => $answer)
                                                        <input class="form-check-input" type="radio"
                                                            wire:model.defer="questionAnswers.{{ $question['id'] }}"
                                                            name="question_answers_{{ $question['id'] }}"
                                                            value="{{ $answer }}">
                                                        <label class="form-check-label">{{ $answer }}</label>
                                                    @endforeach
                                                </small>
                                            @elseif (isset($question['answer']) && $question['answer']['answer_type'] == 'text')
                                                <textarea wire:model.defer="questionAnswers.{{ $question['id'] }}" name="question_answers_{{ $question['id'] }}"
                                                    cols="30" rows="4" class="form-control"></textarea>
                                            @elseif (isset($question['answer']) && $question['answer']['answer_type'] == 'file')
                                                <input type="file"
                                                    wire:model.defer="questionAnswers.{{ $question['id'] }}"
                                                    name="question_answers_{{ $question['id'] }}"
                                                    accept=".pdf,image/jpeg,image/jpg,image/png" class="form-control">
                                                <small style="display: block">الصيغ المقبولة : pdf, jpeg , jpg ,
                                                    png</small>
                                                <small style="display: block">الحجم الاقصى : 1MB</small>
                                            @endif
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-light border">
                                    لا توجد أسئلة إضافية لهذا العطاء
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success me-2"
                                {{ empty($selectedTenderItems) ? 'disabled' : '' }}>
                                <i class="fas fa-paper-plane"></i> تقديم العرض
                            </button>
                            <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">
                                <i class="fas fa-times"></i> إلغاء
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-success {
        background-color: #d4edda !important;
    }

    .modal-xl {
        max-width: 95%;
    }

    .form-control-sm {
        font-size: 0.875rem;
    }

    .badge {
        font-size: 0.75rem;
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-color: #dee2e6;
    }

    .table td {
        vertical-align: middle;
    }

    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }
</style>
