<style>
	body{
		background: #f1f1f1;
	}
	.login{
		background: #fff;
		padding: 10px 15px;
		margin-top: 200px;
		color: #000;
	}
	.input {
	  background-color: #ffffff;
	  height: 40px;
	  width: 100%;
	  margin-bottom: 10px;
	  outline: 0;
	  padding-left: 10px;
	  font-family: 'Source Sans Pro', sans-serif;
	  font-size: 15px;
	  border: 2px solid #dddddd;
	  border-radius: 3px;
	}
	.btn{
	  background: #25B7DB;
	  outline: 0;
	  border: 0px solid #25B7DB;
	  border-radius: 3px;
	  width: 100%;
	  height: 45px;
	  font-family: 'Source Sans Pro', sans-serif;
	  font-size: 14px;
	  color: white;
	  font-weight: 600;
	  text-align: center;
	}
	.input:focus{
		border-color: #25B7DB;
	}
	.head{
		background: none !important;
	}
</style>
<div class="col-md-offset-4 col-md-4 login">
	<div class="col-md-offset-2 col-md-8" style="padding: 20px 0;">
		<img src="/assets/logo.png" class="col-md-10 col-md-offset-1 " style="display: block;">
		<form method="post" action="/admin/auth/login">
			<input class="input" type="email" placeholder="Email" name="user">
			<input class="input" type="password" placeholder="password" name="pass">
			<input class="btn" type="submit" value="Login">
		</form>
	</div>
</div>
