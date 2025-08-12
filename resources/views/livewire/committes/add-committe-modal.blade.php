<div>
    <button type="button" class="btn btn-custome" data-mdb-toggle="modal" data-mdb-target="#addCommitteModal">
        إضافة عضو
    </button>

    <div class="modal fade" id="addCommitteModal" tabindex="-1" aria-labelledby="addCommitteModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCommitteModalLabel">إضافة عضو</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="create">
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم</label>
                            <input type="text" class="form-control" id="title" wire:model="newCommitte.name"
                                required>
                            @error('newCommitte.name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">البريد الإلكتروني</label>
                            <input type="text" class="form-control" id="email" wire:model="newCommitte.email"
                                required>
                            @error('newCommitte.email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="answer_type" class="form-label">الرقم الوظيفي</label>
                            <input type="number" class="form-control" id="job_number"
                                wire:model="newCommitte.job_number" required>
                            @error('newCommitte.job_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="committee_type" class="form-label">نوع اللجنة</label>
                            <select class="form-control" id="committee_type" wire:model="type" required>
                                <option value="internal">لجنة داخلية</option>
                                <option value="external">لجنة خارجية</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">إضافة</button>
                        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">إغلاق</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
