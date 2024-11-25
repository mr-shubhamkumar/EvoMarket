<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products - EvoMarket')]
class ProductPage extends Component
{
  use WithPagination;

  #[Url]
  public $selected_category = [];

  #[Url]
  public $selected_brand = [];

  public function render()
  {
    $productQuery = Product::query()->where('is_active', 1);

    if (!empty($this->selected_category)) {
      $productQuery->whereIn('category_id', $this->selected_category);
    }
    if (!empty($this->selected_brand)) {
      $productQuery->whereIn('brand_id', $this->selected_brand);
    }
    return view('livewire.product-page', [
      'products' => $productQuery->paginate(4),
      'brands' => Brand::query()->where('is_active', 1)->get(['id', 'name', 'slug']),
      'categories' => Category::query()->where('is_active', 1)->get(['id', 'name', 'slug']),
    ]);
  }
}
