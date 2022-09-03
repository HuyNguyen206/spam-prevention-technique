<?php

namespace App\Honeypot\View\Components;

use Illuminate\View\Component;

class Honeypot extends Component
{
    public $fieldName;
    public $fieldTimeName;
    public $minimumTime;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fieldName = config('honeypot.field_name');
        $this->fieldTimeName = config('honeypot.field_time_name');
        $this->minimumTime = config('honeypot.minimum_time');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
            <div class="" style="display: none">
                <!-- Name field, time to flag spam -->
                <div>
                    <x-input id="{{$fieldName}}" type="text" name="{{$fieldName}}" :value="old($fieldName)" />
                </div>
                <div>
                    <x-input id="{{$fieldTimeName}}" type="text" name="{{$fieldTimeName}}" value="{{microtime(true)}}" />
                </div>
            </div>
            blade;

//        return view('components.honeypot');
    }
}
