<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;

class CategorySubcategoryComponent extends Component
{
    public $category_modal = false;

    public $active_category = '';

    public $active_subcategory = '';

    public $active_category_id = '';

    public $active_subcategory_id = '';

    public $categories = [];

    public $subCategories = [];

    public function mount($category_id = null, $subcategory_id = null)
    {

        // While Edit
        if ($category_id && $subcategory_id) {
            $this->subCategories = SubCategory::active()->where('category_id', $category_id)->get();

            $categories = Category::active()->where('id', $category_id)->first();
            $subCategories = SubCategory::active()->where('id', $subcategory_id)->first();

            $this->getSubCategories($category_id, $categories->name);
            $this->setSubCategory($subcategory_id, $subCategories?->name);
        }

        $this->categories = Category::active()->get();
    }

    public function getSubCategories($id, $name)
    {
        $this->subCategories = SubCategory::active()->where('category_id', $id)->get();
        $this->active_category = $name;
        $this->active_category_id = $id;

        $this->active_subcategory = '';
        $this->active_subcategory_id = '';
    }

    public function setSubCategory($id, $name)
    {
        $this->active_subcategory = $name;
        $this->active_subcategory_id = $id;

        $this->closeModal();
    }

    public function openModal()
    {
        $this->category_modal = true;
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function closeModal()
    {
        $this->category_modal = false;
    }

    public function render()
    {
        return view('livewire.category-subcategory-component');
    }
}
