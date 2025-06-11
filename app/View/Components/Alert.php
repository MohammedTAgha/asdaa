<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;
    public function __construct($type = null, $message = null)
    {
        if ($type && $message) {
            $this->type = $type;
            $this->message = $message;
        } else {
            if (session('success')) {
                $this->type = 'success';
                $this->message = session('success');
            } elseif (session('error')) {
                $this->type = 'danger';
                $this->message = session('error');
            } elseif (session('warning')) {
                $this->type = 'warning';
                $this->message = session('warning');
            } else {
                $this->type = 'info';
                $this->message = session('info') ?? '';
            }
        }
    }


    public function render()
    {
        return view('components.alert');
    }
}