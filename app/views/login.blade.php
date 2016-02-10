<!DOCTYPE HTML PUBLIC"-// W3C//DTD XHTML 1.0 Strict//EN"" http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>{{$title}}</title>
    {{ HTML::style('assets/css/login.css') }}
    {{ HTML::style('assets/css/bootstrap.min.css') }}
    <link rel="stylesheet" type="text/css" href="assets/themes/default/easyui.css">
</head>
<body>
    <div class="container">
        <br><br><br><br><br>
        <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4"></div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <h1 id="heading" class="text-info text-uppercase">
            {{$heading}}
            </h1>
            <div id="ajax-load" class="text-success">{{HTML::image('assets/images/ajax-loader.gif')}} Authenticating.........</div><br>
            <div class="well">
                {{ Form::open( array('route'=>'user.login','method'=>'post','id'=>'login')) }}
                        <label for="email"></label>
                        <input id="email" class="form-control" name="username" type="text" value="" {{--value="{{Input::old('username')}}"--}}placeholder="username">
                        <label for="password"></label>
                        <input class="form-control"  name="password" id="password" value="" type="password" placeholder="password">
                       <br>
                        <input id="submitBtn" class="btn btn-primary btn-block" value="Login" type="submit">
                {{Form::close()}}
          </div>
  				<a class="btn btn-primary" href="add">Register</a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4"></div>
    </div>

    </div>
{{HTML::script('assets/jquery.min.js')}}
{{HTML::script('assets/jquery.easyui.min.js')}}
{{HTML::script('assets/login.js')}}
</body>
</html>