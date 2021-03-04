@extends("layouts.default")
@section("title", "BackLog UserStory")
@section("content")

<style>
.dl-this-style dt{
  display: inline-block; /* inline-blockによって幅を可変にします*/
  background-color: #45a7e0; 
  padding: 1px 5px; 
  border: 1px solid #444444;
}
.dl-this-style dd{
  padding-left: 50px;
  margin-left: 30px; 
  margin-top: -17px; 
  border: 2px solid #444444; 
  width: 50%;
}

</style>

    <h1>Backlog</h1>
    <h2>UserStory Detail</h2>

    <div class="dl-this-style">
        <dl>
            <dt>storyId</dt>
            <dd>{{ $viewModel->id }}</dd>
        </dl>
        <dl>
            <dt>story</dt>
            <dd>{{ $viewModel->story }}</dd>
        </dl>
        <dl>
            <dt>authorId</dt>
            <dd>{{ $viewModel->authorId }}</dd>
        </dl>

        @if($viewModel->demo)
            <dl>
                <dt>demo</dt>
                <dd>{{ $viewModel->demo }}</dd>
            </dl>
        @endif

        @if($viewModel->estimation)
            <dl>
                <dt>estimation</dt>
                <dd>{{ $viewModel->estimation }}</dd>
            </dl>
        @endif
    </div>

@endsection
