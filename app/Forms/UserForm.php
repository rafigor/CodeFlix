<?php

namespace CodeFlix\Forms;

use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $id = $this->getData('id');
        if(!$id){
            $id = 0;
        }
        $this
            ->add('name', 'text',[
                'label' => 'Nome',
                'rules' => 'required|max:255'
            ])
            ->add('email', 'email',[
                'label' => 'E-mail',
                'rules' => "required|max:255|unique:users,email,$id"
            ]);
    }
}
