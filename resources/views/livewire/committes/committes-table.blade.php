<div>
    @include('livewire.committes.add-committe-modal')
    <div class="card-body">
        <div class="table-rep-plugin">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>الرقم التعريفي</th>
                            <th>الإسم</th>
                            <th>الرقم الوظيفي</th>
                            <th>نوع اللجنة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($committes as $committe)
                            <tr>
                                <td>{{ $committe->id }}</td>
                                <td>{{ $committe->name }}</td>
                                <td>{{ $committe->job_number }}</td>
                                <td>
                                    @if ($committe->type == 3)
                                        لجنة داخلية
                                    @elseif ($committe->type == 4)
                                        لجنة خارجية
                                    @else
                                        غير محدد
                                    @endif
                                </td>
                                <td>
                                    <button wire:click="delete({{ $committe->id }})" class="btn btn-danger"
                                        wire:confirm="هل انت متأكد من حذف البيانات ؟ لا يمكن استرجاع البيانات المحذوفة">حذف</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $committes->links() }}
        </div>
    </div>
</div>
