<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\VideoUploadForm;
use CodeFlix\Repositories\VideoRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Facades\FormBuilder;

class VideoUploadsController extends Controller
{
    /**
     * @var VideoRepository
     */
    private $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $video = $this->repository->find($id);
        $form = FormBuilder::create(VideoUploadForm::class, [
            'url' => route('admin.videos.uploads.store',['video' => $video->id]),
            'method' => 'POST',
            'model' => $video
        ]);

        return view ('admin.videos.upload', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $form = FormBuilder::create(VideoUploadForm::class);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        if($request->file('thumb')){
            $this->repository->uploadThumb($id, $request->file('thumb'));
        }

        if($request->file('file')){
            $this->repository->uploadFile($id, $request->file('file'));
        }

        $this->repository->update(array_except($form->getFieldValues(),'thumb,file'),$id);

        $request->session()->flash('message','Uploads realizados com sucesso.');

        return redirect()->route('admin.videos.index',['video' => $id]);
    }
}
