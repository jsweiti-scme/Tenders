<div>
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
                                <td>
                                    @if ($tender->status == 4 || $tender->end_date <= Carbon\Carbon::now())
                                    <span style="color: red">مُنتهي</span>
                                    @elseif ($tender->status == 0)
                                    مسودة
                                    @elseif ($tender->status == 1)
                                    <span style="color: green">منشور</span>
                                    @elseif ($tender->status == 2)
                                    <span style="color: red">ملغي</span>
                                    @elseif ($tender->status == 3)
                                    <span style="color: red">مغلق</span>
                                    @endif
                                </td>
                                @if ($tender->committes->first()->pivot->approval == 1)
                                <td>
                                    <button disabled wire:click="CommittesApprove({{ $tender->id }})"
                                        class="btn btn-custome">تمت الموافقة</button>

                                </td>
                                <td>
                                    @if ($tender->is_can_open)
                                    <a wire:key="id-{{ $tender->id }}" href="{{ route('TenderApplicants.index', ['id' => $tender->id]) }}" >
                                        <span data-key="t-specializations" class="btn btn-custome">المتقدمين</span>
                                    </a>
                                    @endif
                                </td>
                                @elseif($tender->status == 0)
                                    <td>
                                        <button disabled class="btn btn-custome">العطاء غير منشور</button>
                                    </td>
                                @elseif ($tender->committes->first()->pivot->approval != 1 && $tender->status == 4 || $tender->end_date <= Carbon\Carbon::now())
                                    <td>
                                        <button wire:click="CommittesApprove({{ $tender->id }})"
                                            class="btn btn-custome" wire:confirm="هل انت متأكد من الموافقة على فتح هذا العطاء ؟ لا يمكن تغيير الحالة فيما بعد">الموافقة</button>
                                    </td>
                                @else
                                    <td>
                                        <button disabled class="btn btn-custome">العطاء لازال مفتوحاً</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{$tenders->links()}}
        </div>
    </div>
</div>
