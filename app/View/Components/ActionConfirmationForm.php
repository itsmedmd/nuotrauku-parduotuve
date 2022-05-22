<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionConfirmationForm extends Component
{
    public $message;
    public $origin;
    public $action;
    public $itemID;
    public $cancelWithID;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message = '', $origin = '', $action = '', $itemID = '', $cancelWithID = '')
    {
        $this->message = $message;
        $this->origin = $origin;
        $this->action = $action;
        $this->itemID = $itemID;
        $this->cancelWithID = $cancelWithID;
    }

    public function cancelAction($passedOrigin, $passedID) {
        if ($passedID == -1) {
            return redirect($passedOrigin);
        } else {
            return redirect($passedOrigin."/".$passedID);
        }
    }

    public function confirmAction($passedAction, $passedID) {
        return redirect()->route($passedAction, $passedID);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.action-confirmation-form');
    }
}
