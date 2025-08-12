<div>
    <button type="button" class="btn btn-custome" data-mdb-toggle="modal" data-mdb-target="#addTenderModal">
        إضافة عطاء
    </button>

    <div class="modal fade" id="addTenderModal" tabindex="-1" aria-labelledby="addTenderModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTenderModalLabel">إضافة عطاء</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="create">
                        <div class="mb-3">
                            <label for="title" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="title" wire:model="newTender.title"
                                required>
                            @error('newTender.title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea type="text" class="form-control" id="description" wire:model="newTender.description" required></textarea>
                            @error('newTender.description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">تاريخ البداية</label>
                            <input type="datetime-local" class="form-control" id="start_date"
                                wire:model="newTender.start_date" required>
                            @error('newTender.start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">تاريخ النهاية</label>
                            <input type="datetime-local" class="form-control" id="end_date"
                                wire:model="newTender.end_date" required>
                            @error('newTender.end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">إضافة</button>
                        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">إغلاق</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
