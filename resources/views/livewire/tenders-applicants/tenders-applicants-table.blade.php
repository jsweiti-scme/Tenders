<div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="alert alert-light border-primary">
                    <h5 class="mb-2">{{ $tender->title }}</h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>حالة الإرساء:</strong>
                            @php
                                $statusColor = 'text-secondary';
                                if ($tender->award_status == 'fully_awarded') {
                                    $statusColor = 'text-success';
                                } elseif ($tender->award_status == 'partially_awarded') {
                                    $statusColor = 'text-warning';
                                } elseif ($tender->award_status == 'open') {
                                    $statusColor = 'text-info';
                                }
                            @endphp
                            <span class="{{ $statusColor }}">
                                @switch($tender->award_status)
                                    @case('fully_awarded')
                                        مُرسى كاملاً
                                    @break

                                    @case('partially_awarded')
                                        مُرسى جزئياً
                                    @break

                                    @case('open')
                                        مفتوح
                                    @break

                                    @default
                                        غير محدد
                                @endswitch
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <strong>نسبة الإنجاز:</strong>
                            <span class="text-primary">{{ $tender->award_progress }}%</span>
                        </div>
                    </div>
                    @if ($tender->total_awarded_amount > 0)
                        <div class="mt-2 text-muted">
                            <strong>إجمالي المبلغ المُرسى:</strong>
                            {{ number_format($tender->total_awarded_amount, 2) }} ₪
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>العنصر</th>
                        <th>الكمية</th>
                        <th>الوحدة</th>
                        <th>العروض المقدمة</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tender->tenderItems as $tenderItem)
                        <tr>
                            <td>
                                <strong>{{ $tenderItem->item->name }}</strong>
                                @if ($tenderItem->item->description)
                                    <br><small class="text-muted">{{ $tenderItem->item->description }}</small>
                                @endif
                            </td>
                            <td>{{ number_format($tenderItem->quantity, 2) }}</td>
                            <td>{{ $tenderItem->item->unit }}</td>
                            <td>
                                @php $bids = $tenderItem->getBidsWithCompanies(); @endphp
                                @if ($bids->count() > 0)
                                    <div class="bids-container">
                                        @foreach ($bids as $index => $bid)
                                            @php
                                                $isWinner =
                                                    $tenderItem->award &&
                                                    $tenderItem->award->winner_user_id ==
                                                        $bid->applicantTender->user_id;
                                            @endphp

                                            <div
                                                class="mb-2 p-2 border rounded {{ $isWinner ? 'bg-success-subtle' : '' }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $bid->applicantTender->user->companyInfo->company_name ?? 'غير محدد' }}</strong>
                                                        <br>
                                                        <span class="text-muted">{{ number_format($bid->price, 2) }}
                                                            ₪</span>
                                                        @if ($index == 0)
                                                            <small class="text-primary">(أقل سعر)</small>
                                                        @endif
                                                        @if ($isWinner)
                                                            <span class="badge bg-success">الفائز</span>
                                                        @endif
                                                    </div>
                                                    @if (auth()->user()->type == 1 && !$tenderItem->isAwarded() && $tender->winner_id == null)
                                                        <button
                                                            wire:click="awardItem({{ $tenderItem->id }}, {{ $bid->id }})"
                                                            class="btn btn-custome"
                                                            wire:confirm="هل تريد إرساء هذا العنصر على شركة {{ $bid->applicantTender->user->companyInfo->company_name ?? 'غير محدد' }}؟">
                                                            إرساء
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">لا توجد عروض</span>
                                @endif
                            </td>
                            <td>
                                @if ($tenderItem->isAwarded() && $tenderItem->award)
                                    <span class="text-success">مُرسى</span>
                                @else
                                    <span class="text-warning">معلق</span>
                                @endif
                            </td>
                            <td>
                                @if (auth()->user()->type == 1)
                                    @if ($tenderItem->isAwarded())
                                        <button wire:click="cancelItemAward({{ $tenderItem->id }})"
                                            class="btn btn-custome" wire:confirm="هل تريد إلغاء إرساء هذا العنصر؟">
                                            إلغاء الإرساء
                                        </button>
                                    @else
                                        <span class="text-muted">في انتظار الإرساء</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">لا توجد عناصر في هذا العطاء</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
