<?php

namespace CodeFlix\Forms;

use Kris\LaravelFormBuilder\Form;

class SerieForm extends Form
{
    public function buildForm()
    {
        $id = $this->getData('id');

        $ruleThumbFile = 'image|max:1024';
        $ruleThumbFile = !$id?"required|$ruleThumbFile" : $ruleThumbFile;

        if(!$id){
            $id = 0;
        }
        $this
            ->add('title', 'text',[
                'label' => 'Título',
                'rules' => 'required|max:255'
            ])
            ->add('description', 'textarea',[
                'label' => 'Descrição',
                'rules' => 'required|max:255'
            ])
            ->add('thumb_file', 'file',[
                'required' => !$id?true:false,
                'label' => 'Thumb',
                'rules' => $ruleThumbFile
            ]);
    }
}
