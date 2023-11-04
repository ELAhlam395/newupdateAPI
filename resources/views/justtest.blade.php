<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @use postcss-nested;

:root {
  --send-bg: #0B93F6;
  --send-color: white;
  --receive-bg: #E5E5EA;
  --receive-text: black;
  --page-background: white;
}

body {
	font-family: "Helvetica Neue", Helvetica, sans-serif;
	font-size: 20px;
	font-weight: normal;
  max-width: 450px;
	margin: 50px auto;
  display: flex;
  flex-direction: column;
  background-color: var(--page-background);
}

p {
  max-width: 255px;
  word-wrap: break-word;
  margin-bottom: 12px;
  line-height: 24px;
  position: relative;
	padding: 10px 20px;
  border-radius: 25px;
  
  &:before, &:after {
    content: "";
		position: absolute;
    bottom: 0;
    height: 25px;
  }
}

.send {
	color: var(--send-color); 
	background: var(--send-bg);
	align-self: flex-end;
		
	&:before {
		right: -7px;
    width: 20px;
    background-color: var(--send-bg);
		border-bottom-left-radius: 16px 14px;
	}

	&:after {
		right: -26px;
    width: 26px;
    background-color: var(--page-background);
		border-bottom-left-radius: 10px;
	}
}
.receive {
	background: var(--receive-bg);
	color: black;
  align-self: flex-start;
		
	&:before {
		left: -7px;
    width: 20px;
    background-color: var(--receive-bg);
		border-bottom-right-radius: 16px 14px;
	}

	&:after {
		left: -26px;
    width: 26px;
    background-color: var(--page-background);
		border-bottom-right-radius: 10px;
	}
}
    </style>
</head>
<body>
    
    <p class="send">Hey there! What's up</p>
<p class="receive">Checking out iOS7 you know..</p>
<p class="send">Check out this bubble!</p>
<p class="receive">It's pretty cool…</p>
<p class="receive">Not gonna lie!</p>
<p class="send">Yeah it's pure CSS &amp; HTML</p>
<p class="receive">Wow that's impressive. But what's even more impressive is that this bubble is really high.</p>
</body>
</html>