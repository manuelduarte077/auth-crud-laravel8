<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{

    public $posts;
    public $postId, $title, $description, $category, $tags, $author;
    public $isOpen = 0;

    // Mostrar los datos en la tabla
    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }

    // Mostrar modal
    public function showModal () {
        $this->isOpen = true;
    }

    // Ocultar Modal
    public function hideModal () {
        $this->isOpen = false;
    }


    // Crear Posts
    public function store () {
        $this->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'category' => 'required',
                'tags' => 'required',
                'author' => 'required'
            ]
        );

        Post::updateOrCreate(['id' => $this->postId],[
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'tags' => $this->tags,
            'author' => $this->author
        ] );

        $this->hideModal();

        session()->flash('info', $this->postId ? 'Post Update Successfully' : 'Post Created Successfully');          

        $this->postId = '';
        $this->title  = '';
        $this->description = '';
        $this->category = '';
        $this->tags = '';
        $this->author = '';

    }

    // Editar Posts
    public function edit($id) {

        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->title  = $post->title;
        $this->description = $post->description;
        $this->category = $post->category;
        $this->tags = $post->tags;
        $this->author = $post->author;

        $this->showModal();

    }

    // Eliminar Posts
    public function delete ($id) {
        Post::find($id)->delete();
    }

}
