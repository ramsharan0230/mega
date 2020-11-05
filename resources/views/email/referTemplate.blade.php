<!DOCTYPE html>
<html>

<head>
	<title>Refer a template</title>
	<style>
		h1 {
			font-family: 'sans-serif, serif';
		}

		.confirm_btn {
			background: #8BC53F;
			color: #fff;
			font-size: 20px;
			font-weight: 600;
			max-width: 150px;
			padding: 10px 20px;
			text-align: center;
			width: 100%;
			height: auto;
			text-transform: initial;
			letter-spacing: 1px;
			text-decoration: none
		}
	</style>
</head>

<body>
	<h1>{{$exhibitor_name}} is organizing online education fair.</h1>
	<p>Please click below link for more details.</p>
	<br>
	<br>
	<a href="{{$exhibitor_url}}" target="_blank" class="confirm_btn">Click Here</a>
</body>

</html>