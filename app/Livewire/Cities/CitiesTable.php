<?php

namespace App\Livewire\Cities;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\City;
class CitiesTable extends Component
{
    use LivewireAlert;
    public $newCity = [
        'city' => '',
    ];

    public function index()
    {
        return view('livewire.cities.index');
    }

    public function render()
    {
        $cities = City::paginate(20);
        return view('livewire.cities.cities-table',compact('cities'));
    }

    public function create()
    {

        $newCity = new City;
        $newCity->city = $this->newCity['city'];
        $newCity->save();

        $this->newCity = [
            'city' => '',
        ];

        $this->alert('success', trans('translation.add_success'));        
    }
    public function update($id, $field, $value)
    {
        $city = City::findOrFail($id);
        $city->$field = $value;
        $city->save();

        $this->alert('success', trans('translation.update_success'));
    }
    public function delete(City $city)
    {
        $city->delete();

        $this->alert('success', trans('translation.delete_success'));
    }
}
