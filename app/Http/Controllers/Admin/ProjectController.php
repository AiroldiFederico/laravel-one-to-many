<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Project;
use Illuminate\Support\Str;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('guest.index', compact('projects'));
    }







    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin\Projects\create');
    }







    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {

    //     $request->validate(
    //         [
    //         'title' => 'required|string|max:255',
    //         'github' => 'required|string|max:255',
    //         'link' => 'required|string|max:255',
    //         'languages' => 'required|string|max:255',
    //         'image' => 'nullable',
    //         ],
    //         [
    //             'title.required' => 'Il campo titolo è obbligatorio.',
    //             'github.required' => 'Il campo GitHub è obbligatorio.',
    //             'link.required' => 'Il campo link è obbligatorio.',
    //             'languages.required' => 'Il campo lingue è obbligatorio.',

    //         ]
    //     );



    //     $form_data = $request->all();
    //     $slug = Project::generateSlug($request->title); // Genera lo slug corretto
    //     $form_data['slug'] = $slug;
    
    //     $new_project = new Project();
    //     $new_project->fill($form_data);
    //     $new_project->save();
        
        
    //     //dd($form_data);

    //     // Creazione di un nuovo progetto con i dati validati
    //     //$new_project = new Project();
    //     // $project->title = $form_data['title'];
    //     // $project->slug = Str::slug($form_data['title'], '-');
    //     // $project->github = $form_data['github'];
    //     // $project->link = $form_data['link'];
    //     // $project->languages = $form_data['languages'];
    //     // $new_project->save();

    //     // Reindirizzamento alla pagina di visualizzazione del progetto appena creato
    //     return redirect()->route('projects.index');


    // }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'github' => 'required|string|max:255',
        'link' => 'required|string|max:255',
        'languages' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048', // Aggiunto il controllo per il tipo e la dimensione dell'immagine
    ], [
        'title.required' => 'Il campo titolo è obbligatorio.',
        'github.required' => 'Il campo GitHub è obbligatorio.',
        'link.required' => 'Il campo link è obbligatorio.',
        'languages.required' => 'Il campo lingue è obbligatorio.',
        'image.image' => 'Il campo immagine deve essere un file di immagine.',
        'image.max' => 'La dimensione massima consentita per l\'immagine è 2 MB.',
    ]);

    $form_data = $request->all();

    if ($request->hasFile('image')) {
        $image_path = $request->file('image')->store('public/images'); // Salva l'immagine nella directory 'public/images'
        $form_data['image'] = $image_path;
    }

    $slug = Project::generateSlug($request->title); // Genera lo slug corretto
    $form_data['slug'] = $slug;

    $new_project = new Project();
    $new_project->fill($form_data);
    $new_project->save();

    return redirect()->route('projects.index');
}





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return view('guest.show', compact('project'));
    }






    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }








    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $form_data = $request->all();

        $project->title = $form_data['title'];
        $project->slug = Str::slug($form_data['title']);
        $project->github = $form_data['github'];
        $project->link = $form_data['link'];
        $project->languages = $form_data['languages'];
        $project->save();
    
        return redirect()->route('admin.projects.show', $project->id);
    }







    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
    
        return redirect()->route('projects.index')->with('success', 'Il progetto è stato eliminato con successo.');
    }
    
}
