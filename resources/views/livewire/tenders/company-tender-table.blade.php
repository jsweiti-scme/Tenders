<div>
<style>
.flex-row {
    display: flex;
}
.flex-th {
    flex: 1;
}
.flex-td {
    flex: 4;
}
</style>
    <div class="card-body">
        <div class="table-rep-plugin">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                @foreach ($tenders as $tender)
                <table id="datatable" class="table table-bordered">
                    <tbody>
                        <tr class="flex-row">
                            <th class="flex-th">الرقم التعريفي</th>
                            <td class="flex-td">{{ $tender->id }}</td>
                        </tr>
                        <tr class="flex-row">
                            <th class="flex-th">العنوان</th>
                            <td class="flex-td">{{ $tender->title }}</td>
                        </tr>
                        <tr class="flex-row">
                            <th class="flex-th">الوصف</th>
                            <td class="flex-td">{{ $tender->description }}</td>
                        </tr>
                        <tr class="flex-row">
                            <th class="flex-th">تاريخ البداية</th>
                            <td class="flex-td">{{ $tender->start_date }}</td>
                        </tr>
                        <tr class="flex-row">
                            <th class="flex-th">اخر موعد للتقديم</th>
                            <td class="flex-td">{{ $tender->end_date }}</td>
                        </tr>
                        <tr class="flex-row">
                            <th class="flex-th">التقديم</th>
                            <td class="flex-td">
                                @include('livewire.tenders.company-tender-apply-modal')
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            </div>
            {{$tenders->links()}}
        </div>
    </div>
</div>
