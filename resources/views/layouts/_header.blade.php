<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <a href="{{ route('posts.create') }}">
                    <i class="fas fa-camera" style="font-size: 250%;color:black"></i>
                </a>
            </div>

            <div class="col-sm-4 text-center">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('storage/images/img/papasta.png') }}" width="58%"/>
                </a>
            </div>

            <div class="col-sm-4 text-right">
                <a href="{{ route('users.show', ['user'=>auth()->user()->id]) }}">
                    <img src="{{ asset('storage/images/img/'.auth()->user()->logo_url) }}" width="13%" style="border-radius: 50%;" />
                </a>
            </div>
        </div>
    </div>
</div>