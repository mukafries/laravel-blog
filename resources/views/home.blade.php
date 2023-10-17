<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel Blog</title>
</head>

<body>

  <!-- code in auth occurs if the user is logged in. SHould normally redirect to home page -->
  @auth
  <p>Congrats, you are logged in</p>
  <form action="/logout" method="post">
    @csrf
    <button>Log Out</button>
  </form>

  <!-- Create post form section -->
  <section>
    <div style="border: 3px solid limegreen; padding: .75em .75em;">
      <h2>Create a New Post</h2>
      <form action="/create-post" method="post">
        @csrf
        <input type="text" name="title" placeholder="post title">
        <textarea name="body" placeholder="content..."></textarea>
        <button>Create</button>
      </form>
    </div>
  </section>

  <!-- All posts created by user -->
  <section>
  <div style="padding: .75em .75em;">
    <h2>All Posts</h2>

    @foreach($posts as $post)
    <div style="border: 2px solid green; padding: 10px; margin: 10px">
      <h3>{{$post['title']}} by {{$post->user->name}}</h3>
      <div>
        {{$post['body']}}
      </div>
      <p><a href="/edit-post/{{$post->id}}">Edit</a></p>

      <form action="/delete-post/{{$post->id}}" method="post">
        @csrf
        @method('DELETE')
        <button>Delete</button>
      </form>
    </div>
    @endforeach

  </div>
</section>



  <!-- else occurs if the user is not logged in -->
  @else
  <section class="register-section">
    <div style="border: 3px solid purple; padding: .75em .25em;">
      <h2 style="padding: 0;">Register</h2>
      <form action="/register" method="POST">
        @csrf
        <input name="name" type="text" placeholder="name">
        <input name="email" type="text" placeholder="email">
        <input name="password" type="password" placeholder="password">
        <button>Register</button>
      </form>
    </div>
  </section>

  <!-- Login section-->
  <section class="login-section">
    <div style="border: 3px solid purple; padding: .75em .25em;">
      <h2 style="padding: 0;">Login</h2>
      <form action="/login" method="POST">
        @csrf
        <input name="login_name" type="text" placeholder="name">
        <input name="login_password" type="password" placeholder="password">
        <button>Login</button>
      </form>
    </div>
  </section>

  @endauth



</body>

</html>