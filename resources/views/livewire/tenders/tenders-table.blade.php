<div>

    @include('livewire.tenders.add-tender-modal')
    <div class="card-body">
        <div class="table-rep-plugin">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>الرقم التعريفي</th>
                            <th>العنوان</th>
                            <th>الوصف</th>
                            <th>تاريخ البداية</th>
                            <th>تاريخ الانتهاء</th>
                            <th>بواسطة</th>
                            <th>اللجنة</th>
                            <th>الاسئلة</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                            <th>المتقدمين</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tenders as $tender)
                            <tr>
                                <td>{{ $tender->id }}</td>
                                <td>{{ $tender->title }}</td>
                                <td>{{ $tender->description }}</td>
                                <td>{{ $tender->start_date }}</td>
                                <td>{{ $tender->end_date }}</td>
                                <td>{{ $tender->CreatedBy->name }}</td>

                                @if ($tender->status == 0)
                                    <td>@include('livewire.tenders.tender-committes-modal', [
                                        'tender' => $tender,
                                    ])</td>
                                    <td>@include('livewire.tenders.tender-questions-modal', [
                                        'tender' => $tender,
                                    ])</td>
                                @else
                                    <td><button type="button" class="btn btn-custome" disabled>اللجنة</button></td>
                                    <td><button type="button" class="btn btn-custome" disabled>الاسئلة</button></td>
                                @endif
                                <td>
                                    @if ($tender->status == 4 || $tender->end_date <= Carbon\Carbon::now())
                                        <span style="color: red">مُنتهي</span>
                                    @elseif ($tender->status == 0)
                                        مسودة
                                        <br>
                                        <button wire:click="PublishTender({{ $tender->id }})" class="btn btn-custome"
                                            wire:confirm="هل انت متأكد من نشر هذا العطاء ؟">نشر</button>
                                    @elseif ($tender->status == 1)
                                        <span style="color: green">منشور</span>
                                    @elseif ($tender->status == 2)
                                        <span style="color: red">ملغي</span>
                                    @elseif ($tender->status == 3)
                                        <span style="color: red">مغلق</span>
                                    @endif
                                </td>
                                <td>
                                    <button wire:click="delete({{ $tender->id }})" class="btn btn-danger"
                                        wire:confirm="هل انت متأكد من حذف البيانات ؟ لا يمكن استرجاع البيانات المحذوفة">حذف</button>
                                </td>
                                <td>
                                    @if ($tender->is_can_open)
                                        <a wire:key="id-{{ $tender->id }}"
                                            href="{{ route('TenderApplicants.index', ['id' => $tender->id]) }}">
                                            <span data-key="t-specializations" class="btn btn-custome">المتقدمين</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $tenders->links() }}
        </div>
    </div>
</div>
