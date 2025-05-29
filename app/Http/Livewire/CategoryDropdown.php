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

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($selectedCategory = null, $selectedSource = null)
    {
        Log::info('CategoryDropdown component mounted', [
            'selectedCategory' => $selectedCategory,
            'selectedSource' => $selectedSource
        ]);

        $this->categories = DistributionCategory::all();
        $this->sources = Source::all();
        $this->selectedCategory = $selectedCategory;
        $this->selectedSource = $selectedSource;
    }

    public function hydrate()
    {
        Log::info('CategoryDropdown component hydrated');
    }

    public function dehydrate()
    {
        Log::info('CategoryDropdown component dehydrated');
    }

    public function updatedSelectedCategory($value)
    {
        Log::info('Selected category updated', ['value' => $value]);
        
        if ($value === 'add_new') {
            $this->showNewCategoryInput = true;
        } else {
            $this->showNewCategoryInput = false;
        }
        
        $this->emit('categorySelected', $value);
    }

    public function updatedSelectedSource($value)
    {
        Log::info('Selected source updated', ['value' => $value]);
        
        if ($value === 'add_new_source') {
            $this->showNewSourceInput = true;
        } else {
            $this->showNewSourceInput = false;
        }
        
        $this->emit('sourceSelected', $value);
    }

    public function addCategory()
    {
        Log::info('Adding new category', ['name' => $this->newCategory]);
        
        $this->validate([
            'newCategory' => 'required|string|max:255',
        ]);

        $category = DistributionCategory::create(['name' => $this->newCategory]);

        $this->categories = DistributionCategory::all();
        $this->selectedCategory = $category->id;
        $this->showNewCategoryInput = false;
        $this->newCategory = '';
        
        $this->emit('categoryAdded', $category->id);
    }

    public function addSource()
    {
        Log::info('Adding new source', [
            'name' => $this->newSourceName,
            'phone' => $this->newSourcePhone,
            'email' => $this->newSourceEmail
        ]);
        
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
        
        $this->emit('sourceAdded', $source->id);
    }

    public function render()
    {
        Log::info('CategoryDropdown component rendering', [
            'selectedCategory' => $this->selectedCategory,
            'selectedSource' => $this->selectedSource
        ]);
        
        return view('livewire.category-dropdown');
    }
}
