<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }
    body{
      width: 100%;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(245, 240, 240, 0.966);
    }
    ::selection{
      color: #fff;
      background: #5372F0;
    }
    .wrapper{
      width: 380px;
      padding: 40px 30px 50px 30px;
      background: #fff;
      border-radius: 5px;
      text-align: center;
      box-shadow: 10px 10px 15px rgba(0,0,0,0.1);
    }
    .wrapper header{
      font-size: 35px;
      font-weight: 600;
    }
    .wrapper form{
      margin: 40px 0;
    }
    form .field{
      width: 100%;
      margin-bottom: 20px;
    }
    form .field.shake{
      animation: shake 0.3s ease-in-out;
    }
    @keyframes shake {
      0%, 100%{
        margin-left: 0px;
      }
      20%, 80%{
        margin-left: -12px;
      }
      40%, 60%{
        margin-left: 12px;
      }
    }
    form .field .input-area{
      height: 50px;
      width: 100%;
      position: relative;
    }
    form input{
      width: 100%;
      height: 100%;
      outline: none;
      padding: 0 45px;
      font-size: 18px;
      background: none;
      caret-color: #866ec7;
      border-radius: 5px;
      border: 1px solid #bfbfbf;
      border-bottom-width: 2px;
      transition: all 0.2s ease;
    }
    form .field input:focus,
    form .field.valid input{
      border-color: #866ec7;
    }
    form .field.shake input,
    form .field.error input{
      border-color: #866ec7;
    }
    .field .input-area i{
      position: absolute;
      top: 50%;
      font-size: 18px;
      pointer-events: none;
      transform: translateY(-50%);
    }
    .input-area .icon{
      left: 15px;
      color: #bfbfbf;
      transition: color 0.2s ease;
    }
    .input-area .error-icon{
      right: 15px;
      color: #dc3545;
    }
    form input:focus ~ .icon,
    form .field.valid .icon{
      color: #866ec7;
    }
    form .field.shake input:focus ~ .icon,
    form .field.error input:focus ~ .icon{
      color: #bfbfbf;
    }
    form input::placeholder{
      color: #bfbfbf;
      font-size: 17px;
    }
    form .field .error-txt{
      color: #dc3545;
      text-align: left;
      margin-top: 5px;
    }
    form .field .error{
      display: none;
    }
    form .field.shake .error,
    form .field.error .error{
      display: block;
    }
    form .pass-txt{
      text-align: left;
      margin-top: -10px;
    }
    .wrapper a{
      color: #5372F0;
      text-decoration: none;
    }
    .wrapper a:hover{
      text-decoration: underline;
    }
    form input[type="submit"]{
      height: 50px;
      margin-top: 30px;
      color: #fff;
      padding: 0;
      border: none;
      background: #866ec7;
      cursor: pointer;
      border-bottom: 2px solid rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }
    form input[type="submit"]:hover{
      background: #9b85d8;
    }
  
  
    button[type="submit"]{
      height: 50px;
      margin-top: 30px;
      color: #fff;
      padding: 0;
      border: none;
      background: #866ec7;
      cursor: pointer;
      border-bottom: 2px solid rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }
    form button[type="submit"]:hover{
      background: #9b85d8;
    }
  </style>
</head>
  <body>
    <div class="wrapper">
      <header>WELCOME!</header>
        <form  action="register" method="POST" >
            <div class="mt-5">
                @if($errors->any())
                    <div class ="col-12">
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    </div>
                @endif

                @if (session()->has('error'))
                <div class="alert alert-danger">{session('error')}</div>
                @endif

                @if (session()->has('success'))
                <div class="alert alert-success">{{session('success')}}</div>
                @endif
             </div>
        @csrf
        <div class="input-area">
            <input type="text" class="form-control" placeholder="First Name" name="fname">
        </div>
        <br>
        <div class="input-area">
            <input type="text" class="form-control" placeholder="Last Name" name="lname">
        </div>
        <br>
        <div class="input-area">
            <input type="text" class="form-control" placeholder="User Name" name="name">
        </div>
        <br>
        <div class="input-area">
         <input type="text" class="form-control" placeholder="Email Address" name="email" >
        </div>
        <br>
        <div class="input-area">
          <input type="text" class="form-control"  placeholder="Password" name="password" >
        </div>


        <!--------------------checkinput--------------------------->
        <div hidden>
          <!-- manger <input  type="radio" value="manger" name="rd" id="flexCheckDefault">
            admin <input  type="radio" value="admin" name="rd" id="flexCheckDefault">-->
            user  <input  type="radio" value="user" name="rd" id="flexCheckDefault" checked>
           <!--none  <input  type="radio" value="none" name="tm" id="flexCheckDefault" checked>-->
           <select  id="" name='tm' class="form-select">
            <!-- <option value='none'>none</option>-->
             @foreach ($showutm as $tem)
             <option value="{{$tem->id}}">{{$tem->Name}}</option>

             @endforeach

           </select>

        </div>


        <div class="d-grid gap-2">
          <button type="submit" class="btn primary">Sign in</button>
        </div>
        <br>
        <div class="sign-txt">
            <a class="nav-link" href="{{url('viewpagehome')}}" style="color:#866ec7">Go back to login</a>

        </div>
      </form>
    </div>

















    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>





<script>
      const form = document.querySelector("form");
  eField = form.querySelector(".email"),
  eInput = eField.querySelector("input"),
  pField = form.querySelector(".password"),
  pInput = pField.querySelector("input");

  form.onsubmit = (e)=>{
    e.preventDefault(); //preventing from form submitting
    //if email and password is blank then add shake class in it else call specified function
    (eInput.value == "") ? eField.classList.add("shake", "error") : checkEmail();
    (pInput.value == "") ? pField.classList.add("shake", "error") : checkPass();

    setTimeout(()=>{ //remove shake class after 500ms
      eField.classList.remove("shake");
      pField.classList.remove("shake");
    }, 500);

    eInput.onkeyup = ()=>{checkEmail();} //calling checkEmail function on email input keyup
    pInput.onkeyup = ()=>{checkPass();} //calling checkPassword function on pass input keyup

    function checkEmail(){ //checkEmail function
      let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/; //pattern for validate email
      if(!eInput.value.match(pattern)){ //if pattern not matched then add error and remove valid class
        eField.classList.add("error");
        eField.classList.remove("valid");
        let errorTxt = eField.querySelector(".error-txt");
        //if email value is not empty then show please enter valid email else show Email can't be blank
        (eInput.value != "") ? errorTxt.innerText = "Enter a valid email address" : errorTxt.innerText = "Email can't be blank";
      }else{ //if pattern matched then remove error and add valid class
        eField.classList.remove("error");
        eField.classList.add("valid");
      }
    }

    function checkPass(){ //checkPass function
      if(pInput.value == ""){ //if pass is empty then add error and remove valid class
        pField.classList.add("error");
        pField.classList.remove("valid");
      }else{ //if pass is empty then remove error and add valid class
        pField.classList.remove("error");
        pField.classList.add("valid");
      }
    }

    //if eField and pField doesn't contains error class that mean user filled details properly
    if(!eField.classList.contains("error") && !pField.classList.contains("error")){
      window.location.href = form.getAttribute("action"); //redirecting user to the specified url which is inside action attribute of form tag
    }
  }
</script>












</html>
