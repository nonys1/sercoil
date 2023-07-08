$(".may").keyup(function(){
  this.value = this.value.toUpperCase();
});
$(".min").keyup(function(){
  this.value = this.value.toLowerCase();
});
//https://cesar.pe/blog/hacer-que-tus-input-solo-reciban-letras-numeros-yo-espacios-con-javascript/
$(".letras").bind('keypress', function(event) {
  var regex = new RegExp("^[a-zA-Z ]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

$(".num").bind('keypress', function(event) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

$(".ao").attr('autocomplete', 'off');

$(".lc").keypress(function(e){
  console.log(this.value.length);
  if (this.value.length>25) {
    e.preventDefault();
    return false;
  }
});

$(".ln").keypress(function(e){
  console.log(this.value.length);
  if (this.value.length>11) {
    e.preventDefault();
    return false;
  }
});