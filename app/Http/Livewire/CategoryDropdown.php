<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DistributionCategory;
use App\Models\Source;
use Illuminate\Support\Facades\Log;

class CategoryDropdown extends Component
{
    public $categories;
    public $sources;
    public $selectedCategory;
    public $selectedSource;
    public $newCategory;
    public $newSourceName;
    public $newSourcePhone;
    public $newSourceEmail;
    public $showNewCategoryInput = false;
    public $showNewSourceInput = false;

    public function mount($selectedCategory = null, $selectedSource = null)
    {
        Log::info('livewire mount');

        $this->categories = DistributionCategory::all();
        $this->sources = Source::all();
        $this->selectedCategory = $selectedCategory;
        $this->selectedSource = $selectedSource;
    }

    public function updatedSelectedCategory($value)
    {
        if ($value === 'add_new') {
            $this->showNewCategoryInput = true;
        } else {
            $this->showNewCategoryInput = false;
        }
    }

    public function updatedSelectedSource($value)
    {
        Log::info('livewire', $this->showNewSourceInput);
        Log::info('livewire value', $value);
        if ($value === 'add_new_source') {
            $this->showNewSourceInput = true;
        } else {
            $this->showNewSourceInput = false;
        }
    }

    public function addCategory()
    {
        $this->validate([
            'newCategory' => 'required|string|max:255',
        ]);

        $category = DistributionCategory::create(['name' => $this->newCategory]);

        $this->categories = DistributionCategory::all();
        $this->selectedCategory = $category->id;
        $this->showNewCategoryInput = false;
        $this->newCategory = '';
    }

    public function addSource()
    {
        $this->validate([
            'newSourceName' => 'required|string|max:255',
            'newSourcePhone' => 'nullable|string|max:15',
            'newSourceEmail' => 'nullable|email',
        ]);

        $source = Source::create([
            'name' => $this->newSourceName,
            'phone' => $this->newSourcePhone,
            'email' => $this->newSourceEmail,
        ]);

        $this->sources = Source::all();
        $this->selectedSource = $source->id;
        $this->showNewSourceInput = false;
        $this->newSourceName = '';
        $this->newSourcePhone = '';
        $this->newSourceEmail = '';
    }

    public function render()
    {
        return view('livewire.category-dropdown');
    }
}
