<?php

namespace App\Observers;

use App\Models\Category;


class CategoryObserver
{
    public function creating(Category $category)
    {
        if (blank($category->name_bn)) {
            $category->name_bn = $category->name_en;
        }
    }

    public function updating(Category $category)
    {
        // If category is being deactivated
        if ($category->isDirty('is_active') && $category->is_active === false) {
            $this->deactivateChildren($category);
        }
    }

    protected function deactivateChildren(Category $category): void
    {
        foreach ($category->children as $child) {
            if ($child->is_active) {
                $child->update(['is_active' => false]);
                $this->deactivateChildren($child);
            }
        }
    }
}
