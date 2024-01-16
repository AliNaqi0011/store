@extends('layouts.main')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.settings') }}">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
        <div class="main-body">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Blog Create</h4>
                        <form class="forms-sample" action="{{route('blog.update')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$blogs->id}}">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Title</label>
                                <input type="text" name="title" class="form-control" id="exampleInputUsername1"
                                       value="{{$blogs->title}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="test" name="slug" class="form-control" id="exampleInputEmail1"
                                       value="{{$blogs->slug}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta Tags</label>
                                <input type="text" name="tags" class="form-control" id="exampleInputPassword1"
                                       value="{{$blogs->tags}}">
                            </div>
                            <div class="form-group">
                                <label for="editor">Meta Description</label>
                                <div id="editor">{!! $blogs->meta_description !!} </div>
                                <input type="hidden" name="description" id="editorContent">
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Update</button>
                            <button class="btn btn-light">Reset Form</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .then( editor => {
                // Update the hidden input field whenever the content changes
                editor.model.document.on( 'change:data', () => {
                    document.getElementById('editorContent').value = editor.getData();
                });
            })
            .catch( error => {
                console.error( error );
            });
    </script>
@endsection
