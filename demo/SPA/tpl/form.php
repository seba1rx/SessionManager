<div class="col-12">
    <form id="loginForm" name="loginForm" onsubmit="return tryToAuthenticate(event)" class="form-inline mt-2">
        <input type="email" title="Enter email" class="form-control mr-1" name="useremail" placeholder="email@example.com" value="demo@mail.com">
        <input type="password" title="Enter password" class="form-control mr-1" name="userpassword" value="your_password_here">
        <button type="submit" class="btn btn-info">Authenticate</button>
    </form>
</div>

<script>
    function tryToAuthenticate(event){
        event.preventDefault();

        var data = $('#loginForm').serializeArray();
        App.request.post({url: "/authenticate",  data: data});
    };
</script>