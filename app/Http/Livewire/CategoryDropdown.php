<?php

namespace App\Http\Livewire;
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DistributionCategory;

class CategoryDropdown extends Component
{
    public $categories;
    public $selectedCategory;
    public $newCategory;
    public $showNewCategoryInput = false;

    public function mount($selectedCategory = null)
    {
        $this->categories = DistributionCategory::all();
        $this->selectedCategory = $selectedCategory;
    }

    public function updatedSelectedCategory($value)
    {
        if ($value === 'add_new') {
            $this->showNewCategoryInput = true;
        } else {
            $this->showNewCategoryInput = false;
        }
    }

    public function addCategory()
    {
        $this->validate([
            'newCategory' => 'required|string|max:255',
        ]);

        $category = DistributionCategory::create(['name' => $this->newCategory]);

        // Update categories list
        $this->categories = DistributionCategory::all();

        // Select the newly created category
        $this->selectedCategory = $category->id;

        // Hide the input and clear the new category field
        $this->showNewCategoryInput = false;
        $this->newCategory = '';
    }

    public function render()
    {
        return view('livewire.category-dropdown');
    }
}