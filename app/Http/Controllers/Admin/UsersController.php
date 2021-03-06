<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Repositories\UserRepository;
use CodeFlix\Forms\UserForm;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Kris\LaravelFormBuilder\Form;

class UsersController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->repository->paginate();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = FormBuilder::create(UserForm::class, [
           'url' => route('admin.users.store'),
            'method' => 'POST'
        ]);

        return view ('admin.users.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var Form $form */
        $form = FormBuilder::create(UserForm::class);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $this->repository->create($form->getFieldValues());

        $request->session()->flash('message','Usuário criado com sucesso.');

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \CodeFlix\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->repository->find($id);
        return view ('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CodeFlix\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->repository->find($id);
        $form = FormBuilder::create(UserForm::class, [
            'url' => route('admin.users.update',['user' => $id]),
            'method' => 'PUT',
            'model' => $user
        ]);

        return view ('admin.users.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CodeFlix\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var Form $form */
        $form = FormBuilder::create(UserForm::class, [
            'data' => ['id' => $id]
        ]);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = array_except($form->getFieldValues(),['password','role']);

        $this->repository->update($data, $id);

        $request->session()->flash('message','Usuário alterado com sucesso.');

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CodeFlix\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);

        $request->session()->flash('message','Usuário excluído com sucesso.');

        return redirect()->route('admin.users.index');
    }
}
