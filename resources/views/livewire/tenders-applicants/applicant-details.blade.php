<div>
    <button type="button" class="btn btn-custome" data-bs-toggle="modal"
        data-bs-target="#addQuestionModal{{ $applicant->id }}">
        التفاصيل
    </button>

    <div class="modal fade" id="addQuestionModal{{ $applicant->id }}" tabindex="-1"
        aria-labelledby="addQuestionModalLabel{{ $applicant->id }}" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionModalLabel{{ $applicant->id }}">تفاصيل التقديم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card mb-3">
                        <div class="card-header">معلومات الشركة</div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>الرقم التعريفي</th>
                                        <th>اسم الشركة</th>
                                        <th>رقم الجوال</th>
                                        <th>رقم ارضي</th>
                                        <th>العنوان</th>
                                        <th>رقم المشتغل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $applicant->CompanyInfo->id }}</td>
                                        <td>{{ $applicant->CompanyInfo->company_name }}</td>
                                        <td>{{ $applicant->CompanyInfo->mobile_number }}</td>
                                        <td>{{ $applicant->CompanyInfo->phone_number }}</td>
                                        <td>{{ $applicant->CompanyInfo->City->city }} -
                                            {{ $applicant->CompanyInfo->address }}</td>
                                        <td>{{ $applicant->CompanyInfo->license_worker_number }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">إجابات الأسئلة</div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>الرقم التعريفي</th>
                                        <th>العنوان</th>
                                        <th>الوصف</th>
                                        <th>نوع السؤال</th>
                                        <th>الإجابة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applicant->applicantAnswers as $answer)
                                        <tr>
                                            <td>{{ $answer->question->id }}</td>
                                            <td>{{ $answer->question->title }}</td>
                                            <td>{{ $answer->question->description }}</td>
                                            <td>
                                                {{ $answer->question->Answer->answer_type_ar }}
                                                @if ($answer->question->Answer->answer_type == 'multiple_choice')
                                                    <small style="display: block">
                                                        @foreach (json_decode($answer->question->answers) as $loopIndex => $answer1)
                                                            {{ $loopIndex + 1 }}. {{ $answer1 }}
                                                        @endforeach
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($answer->question->Answer->answer_type == 'file')
                                                    @if (pathinfo($answer->answer, PATHINFO_EXTENSION) == 'pdf')
                                                        <object data="{{ Storage::url($answer->answer) }}"
                                                            type="application/pdf"></object>
                                                    @else
                                                        <img src="{{ Storage::url($answer->answer) }}"
                                                            alt="لا يوجد صورة" width="200">
                                                    @endif
                                                @else
                                                    {{ $answer->answer }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">البنود المختارة</div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>الرقم التعريفي للبند</th>
                                        <th>اسم البند</th>
                                        <th>الوصف</th>
                                        <th>الوحدة</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                        <th>المجموع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applicant->applicantTenderItems as $tenderItem)
                                        <tr>
                                            <td>{{ $tenderItem->tenderItem->id }}</td>
                                            <td>{{ $tenderItem->tenderItem->item->name }}</td>
                                            <td>{{ $tenderItem->tenderItem->item->description }}</td>
                                            <td>{{ $tenderItem->tenderItem->item->unit }}</td>
                                            <td>{{ $tenderItem->tenderItem->quantity }}</td>
                                            <td>{{ number_format($tenderItem->price, 2) }}</td>
                                            <td>{{ number_format($tenderItem->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
