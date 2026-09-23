<?php

namespace App\Http\Controllers\Pages\Admin\Settings;

use App\Http\Controllers\PageController;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuBuilder extends PageController
{
    public $activeMenuId;

    public $menus;

    // For adding/editing item
    public $editingItemId = null;

    public $itemTitle = '';

    public $itemUrl = '';

    public $itemIcon = '';

    public $itemTarget = '_self';

    public $itemParentId = null;

    public $itemBadge = '';

    public $showItemModal = false;

    public function mount()
    {
        // Ensure default menus exist
        $locations = [
            'main' => 'Main Navigation',
            'footer_1' => 'Footer Column 1',
            'footer_2' => 'Footer Column 2',
            'footer_3' => 'Footer Column 3',
            'footer_4' => 'Footer Column 4',
            'mobile_drawer' => 'Mobile Drawer',
            'bottom_nav' => 'Bottom Navigation',
        ];

        foreach ($locations as $loc => $name) {
            Menu::firstOrCreate(['location' => $loc], ['name' => $name, 'is_active' => true]);
        }

        $this->menus = Menu::all();
        $this->activeMenuId = $this->menus->first()->id ?? null;
    }

    public function getActiveMenuProperty()
    {
        return Menu::with(['parentItems.children'])->find($this->activeMenuId);
    }

    public function switchMenu($id)
    {
        $this->activeMenuId = $id;
    }

    public function openItemModal($parentId = null)
    {
        $this->resetItemForm();
        $this->itemParentId = $parentId;
        $this->showItemModal = true;
    }

    public function editItem($id)
    {
        $item = MenuItem::find($id);
        if ($item) {
            $this->editingItemId = $item->id;
            $this->itemTitle = $item->title;
            $this->itemUrl = $item->url;
            $this->itemIcon = $item->icon;
            $this->itemTarget = $item->target;
            $this->itemParentId = $item->parent_id;
            $this->itemBadge = $item->badge;
            $this->showItemModal = true;
        }
    }

    public function resetItemForm()
    {
        $this->editingItemId = null;
        $this->itemTitle = '';
        $this->itemUrl = '';
        $this->itemIcon = '';
        $this->itemTarget = '_self';
        $this->itemParentId = null;
        $this->itemBadge = '';
    }

    public function saveItem()
    {
        $this->validate([
            'itemTitle' => 'required|string|max:255',
            'itemUrl' => 'nullable|string|max:255',
            'itemBadge' => 'nullable|string|max:50',
        ]);

        if ($this->editingItemId) {
            $item = MenuItem::find($this->editingItemId);
            $item->update([
                'title' => $this->itemTitle,
                'url' => $this->itemUrl,
                'icon' => $this->itemIcon,
                'target' => $this->itemTarget,
                'parent_id' => $this->itemParentId,
                'badge' => $this->itemBadge,
            ]);
            $this->toast('Menu item updated!', 'success', 'Success');
        } else {
            $maxOrder = MenuItem::where('menu_id', $this->activeMenuId)
                ->where('parent_id', $this->itemParentId)
                ->max('order');

            MenuItem::create([
                'menu_id' => $this->activeMenuId,
                'title' => $this->itemTitle,
                'url' => $this->itemUrl,
                'icon' => $this->itemIcon,
                'target' => $this->itemTarget,
                'parent_id' => $this->itemParentId,
                'badge' => $this->itemBadge,
                'order' => $maxOrder !== null ? $maxOrder + 1 : 0,
            ]);
            $this->toast('Menu item added!', 'success', 'Success');
        }

        $this->showItemModal = false;
        $this->resetItemForm();
    }

    public function deleteItem($id)
    {
        MenuItem::where('id', $id)->delete();
        $this->toast('Menu item deleted.', 'success', 'Success');
    }

    public function updateOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            MenuItem::where('id', $id)->update(['order' => $index]);
        }

        $this->toast('Menu order updated successfully!', 'success', 'Success');
    }

    public function render()
    {
        return view('pages.admin.settings.menu-builder')
            ->layout('layouts.app', ['title' => 'Menu Builder']);
    }
}
