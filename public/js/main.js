$(document).ready(function(){

//----------------------------EMAIL PLACEHOLDER CHANGE------------------------------------
/*========================================================================================
==========================================================================================
==========================================================================================*/
    var placeHolder = ['example@mail.com','example@mail.co','example@mail.c','example@mail.',
                       'example@mail','example@mai','example@ma','example@m',
                       'example@','example','exampl','examp',
                       'exam','exa','ex','e','','ex','exa','exam',
                       'examp','exampl','example','example@','example@m',
                       'example@ma','example@mai','example@mail','example@mail.',
                       'example@mail.c','example@mail.co','example@mail.com'];
    var n=0;
    var loopLength=placeHolder.length;

    setInterval(function(){
       if(n<loopLength){
          var newPlaceholder = placeHolder[n];
          n++;
          $('.email-placeholder-change').attr('placeholder',newPlaceholder);
       } else {
          $('.email-placeholder-change').attr('placeholder',placeHolder[0]);
          n=0;
       }
    },100);


//----------------------------EMAIL PLACEHOLDER CHANGE END--------------------------------
/*========================================================================================
==========================================================================================
==========================================================================================*/

// ----------------------------For Register-----------------------------------------------
$('#operator-numbers').change(function(){
 var op_num = $(this).val();
$('#operator').attr('value',op_num);
return false;
});

$('#CitySelectOption').change(function(){
 var city_option = $(this).val();
$('#city').attr('value',city_option);
return false;
});
//-----------------------------For Register End -------------------------------------------

//------------------------------For searchBoxDrag -----------------------------------------
$('#searchBoxDrag').draggable({
          containment: '#InfoMap'
      });
});
//------------------------------For searchBoxDrag End -------------------------------------
//------------------------------For Login Ajax --------------------------------------------
$('#SubmitLogin').submit(function(event) {
  event.preventDefault();
  var Login = $.ajax({
    url: '/login',
    type: 'POST',
    dataType: 'json',
    headers:{
    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
  },
    data: {
      email: $('#email').val(),
      password: $('#pass').val()
    },
    success: function(data){

    },
    error:function(data){
      var errors = data.responseJSON;
      console.log(errors);
    }
  })
  Login.done(function(data) {
    location.reload();
  })
});
//------------------------------For Login Ajax End ----------------------------------------
