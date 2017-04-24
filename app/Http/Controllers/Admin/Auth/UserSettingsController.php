<?php

namespace CodeFlix\Http\Controllers\Admin\Auth;

use CodeFlix\Forms\UserSettingsForm;
use CodeFlix\Repositories\UserRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\Facades\FormBuilder;

class UserSettingsController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    //
    public function edit(){
        $form = FormBuilder::create(UserSettingsForm::class, [
            'url' => route('admin.user_settings.update'),
            'method' => 'PUT'
        ]);

        return view ('admin.auth.setting', compact('form'));

    }

    public function update(Request $request){
        /** @var Form $form */
        $form = FormBuilder::create(UserSettingsForm::class);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $this->repository->update($form->getFieldValues(), Auth::user()->id);

        $request->session()->flash('message','Senha alterada com sucesso.');

        return redirect()->route('admin.dashboard');

    }
}
