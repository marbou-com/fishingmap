@extends('layouts.admin-app')

@section('content')
  <div class="p-user-show">

      <!--成功メッセージ-->
      @if(session('massage'))
        <div class="m-3 alert alert-primary">
          {{ session('massage') }}
        </div>
      @endif

      <!--エラー-->
      @foreach ($errors->all() as $err)
        <div class="m-3 alert alert-danger">
          <li>{{ $err }}</li>
        </div>
      @endforeach


    <form class="row " action="{{ route( 'users.update' , ['user'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="c-user-profile">
        <div class="profile">

            <div class="profile-image">
              @if($user->logo_url)
                <img src="{{ asset('storage/images/img/'.$user->logo_url) }}" alt="" style="width:100%" >
              @else
                <img src="{{ asset('storage/images/img/avater.png') }}" alt="" style="width:100%" >
              @endif
            </div>

            <div class="mb-3">
              <input id="logo_url" type="file" name="logo_url">
            </div>


            <div class="profile-user-settings">

              <div class="mb-3">
                <label for="name" class="form-label">name</label>
                <input type="text" class="form-control" name="name" placeholder="" value="{{ $user->name }}">
              </div>

              <div class="mb-3">
                <label for="mail" class="form-label">email</label>
                <input type="email" class="form-control" name="email" placeholder="" value="{{ $user->email }}">
              </div>

              <div class="mb-3">
                <label for="description" class="form-label">description</label>
                <textarea type="description" class="form-control" name="description" placeholder="" >{{ $user->description }}</textarea>
              </div>

              <!--
              <div class="mb-3">
                <label for="mail" class="form-label">password</label>
                <input type="text" class="form-control" name="password" placeholder="" value="{{ $user->password }}">
              </div>
            -->

                <button type="submit" class="profile-edit-btn btn-primary">update</button>

            </div>

        </div>
      </div>

    </form>

  </div>
@endsection