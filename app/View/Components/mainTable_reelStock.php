<?php

namespace App\View\Components;

use Illuminate\View\Component;

class mainTable_reelStock extends Component
{


    public $article;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($article)
    {
        $this->article = $article;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.main-table_reel-stock');
    }
}
