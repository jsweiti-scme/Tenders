<div>
    <button type="button" class="btn btn-custome" data-mdb-toggle="modal" data-mdb-target="#addCityModal">
        إضافة مدينة
    </button>

    <div class="modal fade" id="addCityModal" tabindex="-1" aria-labelledby="addCityModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCityModalLabel">إضافة مدينة</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="create">
                        <div class="mb-3">
                            <label for="name" class="form-label">المدينة</label>
                            <input type="text" class="form-control" id="city" wire:model="newCity.city">
                            @error('newCity.city') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-success">إضافة</button>
                        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal" >إغلاق</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
