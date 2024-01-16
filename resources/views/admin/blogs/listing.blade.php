@extends('layouts.main')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.settings') }}">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">Listing</li>
            </ol>
        </nav>
        <div class="main-body">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Blogs Table</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>
                                        Title
                                    </th>
                                    <th>
                                        Slug
                                    </th>
                                    <th>
                                        Tags
                                    </th>
                                    <th>
                                        Description
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>
                                            {{ $blog->title }}
                                        </td>

                                        <td>
                                            {{ $blog->slug }}
                                        </td>
                                        <td>
                                            {{ $blog->tags }}
                                        </td>
                                        <td>
                                            {!! $blog->meta_description !!}
                                        </td>
                                        <td>

                                            <a href="{{route('blog.delete',$blog->id)}}"  class=""><i class="typcn typcn-archive text-danger"></i> </a>
                                            &nbsp &nbsp
                                            <a href="{{route('blog.edit',$blog->id)}}" class=""><i class="typcn typcn-edit  text-primary"></i> </a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
