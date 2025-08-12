<div>
    @include('livewire.cities.add-city-modal')    
    <div class="card-body">
        <div class="table-rep-plugin">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>الرقم التعريفي</th>
                            <th>المدينة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cities as $city)
                            <tr>
                                <td wire:blur="update({{ $city->id }}, 'id', $event.target.innerText)" contenteditable="false">{{ $city->id }}</td>
                                <td wire:blur="update({{ $city->id }}, 'city', $event.target.innerText)" contenteditable="true">{{ $city->city }}</td>
                                <td>
                                    <button wire:click="delete({{ $city->id }})"
                                        class="btn btn-danger" wire:confirm="هل انت متأكد من حذف البيانات ؟ لا يمكن استرجاع البيانات المحذوفة">حذف</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{$cities->links()}}
        </div>
    </div>
</div>