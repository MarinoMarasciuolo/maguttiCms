<?php

namespace App\maguttiCms\Website\Controllers;

use App\Http\Controllers\Controller;

use App\maguttiCms\Domain\Contact\ContactViewModel;

class ContactController extends Controller
{
    public function __invoke()
    {
        return (new ContactViewModel())->handle('contacts');
    }
}