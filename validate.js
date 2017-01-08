function onlyUnique(value, index, self) 
{ 
    return self.indexOf(value) === index
}
function validate_askForm()
{
    var ret_varibale = false
            var x = document.forms["myForm"]["title"].value
            x = x.trim()
            //console.log("x is",x)
            if (x == null || x == " " || x == "")
            {
                //console.log("x is",x)
                alert("Title must be filled out")
                return false
            }
            if (x.length < 10)
            {
                alert("Title should be minimum of 10 characters")
                return false
            }
    var markupStr = $('#summernote').summernote('code')
    if (markupStr.length < 20)
    {
        alert("Question Content should be minimum of 20 characters")
        return false
    }
    var res = markupStr.split("")
    var unique = res.filter( onlyUnique )
    //console.log(unique)
    len=unique.length
    for(i=0; i<len; i++)
    {
        if(unique[i] == 'p' || unique[i] == 'b' || unique[i] == 'r' || unique[i] == '<' || unique[i] == '>' || unique[i] == '/' || unique[i] == '&' || unique[i] == 'n' || unique[i] == 's' || unique[i] == ';' || unique[i] == ' ' || unique[i] == null)
        {
           
        }
        else
        {
            console.log(unique[i])
            ret_varibale = true
            console.log(ret_varibale)
            return ret_varibale
        }
              
    }
    alert("Question content should not be empty")
    console.log(ret_varibale)
    return ret_varibale
    
}
function validate_myanswerForm() {
    var ret_varibale = false
    var markupStr = $('#summernote').summernote('code')
    if (markupStr.length < 20)
    {
        alert("Answer should be minimum of 20 characters")
        return false
    }
    var res = markupStr.split("")
    var unique = res.filter( onlyUnique )
    //console.log(unique)
    len=unique.length
    for(i=0; i<len; i++)
    {
        if(unique[i] == 'p' || unique[i] == 'b' || unique[i] == 'r' || unique[i] == '<' || unique[i] == '>' || unique[i] == '/' || unique[i] == '&' || unique[i] == 'n' || unique[i] == 's' || unique[i] == ';' || unique[i] == ' ' || unique[i] == null)
        {
           
        }
        else
        {
            console.log(unique[i])
            ret_varibale = true
            console.log(ret_varibale)
            return ret_varibale
        }
              
    }
    alert("Answer box should not be empty")
    console.log(ret_varibale)
    return ret_varibale
    
}

function validate_loginForm() {
    var x = document.forms["login_validform"]["username"].value
    console.log(x)
    if (x == null || x == "") {
        alert("username should not be empty")
        return false
        
    }
    
    var z = document.forms["login_validform"]["password"].value
    console.log(z)
    if (z == null || z == "") {
        alert("password should not be empty")
        return false
        
    }
    }

function validate_signupform()
{
    var x = document.forms["signup_validform"]["username"].value
    console.log(x)
    if (x == null || x == "") {
        alert("User Name is a required field")
        return false
        
    }
    re = /^\w+$/;
    if(!re.test(x)) {
      alert("Error: Username must contain only letters, numbers and underscores!");
      //form.username.focus();
      return false
    }
    
    if (x.length < 4){
        alert("User Name should be minimum of 4 characters")
        return false
    }
    
    var z = document.forms["signup_validform"]["password"].value
    console.log(z)
    if (z == null || z == "") {
        alert("Password is a required field")
        return false   
    }
    if (z.length < 6){
        alert("Password should be minimum of 6 characters")
        return false
    }
    
    var m = document.forms["signup_validform"]["confirmpassword"].value
    if (m == null || m == "") {
        alert("Confirm Password is a required field")
        return false   
    }
    if (z != m){
       alert("Confirm password doesn't match with the entered password") 
       return false
    }
    
    
}