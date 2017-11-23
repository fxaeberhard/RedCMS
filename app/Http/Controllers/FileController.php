<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Project;


class FileController extends Controller
{
    function index() {
	    // $tasks = Task::orderBy('created_at', 'asc')->get();

	    // Page::all()
	    // Page::where($column , '=', $id)->first()

	    // $projects = Project::get();
	    	
	    return view('admin.files', [
	        // 'files' => $projects
	    ]);
    }

   public function store(Request $request){
      $file = $request->file('file');
   
      //Display File Name
      echo 'File Name: '.$file->getClientOriginalName();
      echo '<br>';
   
      //Display File Extension
      echo 'File Extension: '.$file->getClientOriginalExtension();
      echo '<br>';
   
      //Display File Real Path
      echo 'File Real Path: '.$file->getRealPath();
      echo '<br>';
   
      //Display File Size
      echo 'File Size: '.$file->getSize();
      echo '<br>';
   
      //Display File Mime Type
      echo 'File Mime Type: '.$file->getMimeType();
   
      //Move Uploaded File
      $destinationPath = 'upload';
      $file->move($destinationPath,$file->getClientOriginalName());
   }
}
