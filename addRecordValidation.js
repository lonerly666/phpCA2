


function checkValidation()
{

    var recordName = document.getElementById("name").value;
    var recordPrice = document.getElementById("price").value;
    if(recordName===""&&recordPrice==="")
    {
        document.getElementById("nameErr").innerHTML = "Please enter a value";
        document.getElementById("priceErr").innerHTML = "Please enter a value";
        event.preventDefault();
    }
    else if(recordPrice===""&&recordName!=="")
    {
        document.getElementById("priceErr").innerHTML = "Please enter a value";
        event.preventDefault();
    }
    else if(recordName===""&& recordPrice!=="")
    {
        document.getElementById("nameErr").innerHTML = "Please enter a value";
        event.preventDefault();
    }
    else{}
}
function checkCategory()
{
    var recordName = document.getElementById("name").value;
    if(recordName=="")
    {
        document.getElementById("nameErr").innerHTML = "Please enter a name"
        event.preventDefault();
    }
}