<h1>Home Page</h1>

@include('common.header',['pageName'=>'this is Home page'])

<a href="{{ route('Home') }}">Home</a>
<a href="{{ route('About') }}">About</a>
<a href="{{ route('Form') }}">Form</a>