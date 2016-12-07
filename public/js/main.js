$(document).ready(function(){

//----------------------------MAP HEIGHT FOR WINDOW SIZE----------------------------------
    var windowHeightCalc = $('body').height()-150;
    $('#InfoMap').css({
      width: '100%',
      height: windowHeightCalc
    });
//----------------------------MAP HEIGH FOR WINDOW SIZE END-------------------------------

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




//----------------------------PROFIL CHOOSE FILE BUTTON DEYISHMEK--------------------------------

        $('.forImg').click(function() {
          $('.imgInput').click();
        });

//----------------------------EMAIL PLACEHOLDER CHANGE END--------------------------------



//----------------------------EMAIL PLACEHOLDER CHANGE END--------------------------------
/*========================================================================================
==========================================================================================
==========================================================================================*/

// ----------------------------ISTEK DESTEK EDIT CHOOSE FILE-----------------------------------------------

$("#uploadAjax").change(function(e) {
    e.preventDefault();
    var imgs = $(".im_").length;
    var added = e.originalEvent.srcElement.files.length;

    var total = imgs+added;
    if(total > 5) {
        alert('Maximum sekil sayi 5-dir');
    }
   else {
      var formData = new FormData();
      var istek_id = $('#forPicsAjax').val();
      formData.append('file', $(this)[0].files[0]);
      formData.append('istek_id', istek_id);

      $.ajax({
        url: '/add_file_change',
        type: 'post',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        headers:{
      'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
        },
        data: formData,

        success:function(file_name)
        {
          if(file_name != "error"){

            $(e.originalEvent.srcElement.files).each(function () {

              var file = $(this);
              var img = document.createElement("img");
              var reader = new FileReader();

              reader.onload = function(e) {
                  img.src = e.target.result;
                  img.className = 'im_';
                  img.setAttribute("imagename", file[0].name);

              }

              reader.readAsDataURL(file[0]);
            $("#afterImage").after('<div class="img-wrap" imagename="'+file[0].name+'"></div>');
              $(".img-wrap[imagename='"+file[0].name+"']").append('<span class="close" imagename="'+file_name+'">&times;</span>');
              $(".img-wrap[imagename='"+file[0].name+"']").attr('data-remove', file_name).append(img);
            })
            }else{
              $('#ajaxErrorImage').attr('class', 'alert alert-danger');
              $('#ajaxErrorImage').append('<p style="padding:10px;">Düzgün şəkil seçin</p>'); 
            }          
          }
      });
    };
  });

// ----------------------------ISTEK EDIT CHOOSE FILE END-----------------------------------------------



// ----------------------------UPLOAD FILE LIMIT AND SHOWING-----------------------------------------------

  $('#forLimitFile').change(function(e){
    var length = e.originalEvent.srcElement.files.length;
      if(length > 5)
          alert('5-den cox şekil secmeyin');
        else{
          $('#viewImage').empty();
           $(e.originalEvent.srcElement.files).each(function () {
          var file = $(this);
          
          var check = checkExtension(file[0].name).toLowerCase(); 
            if(check=='jpg' || check=='jpeg' || check=='png'){

                var img = document.createElement("img");
                var reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file[0]);
                $("#viewImage").append('<div class="img-wrap"  imagename="'+file[0].name+'"></div>');
                $(".img-wrap[imagename='"+file[0].name+"']").append(img);
            } else{
              $('#ajaxErrorImage').attr('class', 'alert alert-danger');
              $('#ajaxErrorImage').append('<p>Düzgün şəkil seçin</p>'); 
            }     

        });
      }
  });

  $('form').submit(function(){
    console.log(length);
      if(length >5){
        alert("yeniden secin");
          return false;
      }
  });


    function checkExtension (name) {
      var found = name.lastIndexOf('.') + 1;
       return (found > 0 ? name.substr(found) : "");
    }

// ----------------------------UPLOAD FILE LIMIT END-----------------------------------------------



// ----------------------------ISTEK EDIT WHEN CLICKING X ON PIC-----------------------------------------------


  $(document).on('click', '.close', function(){
      var name = $(this).attr('imagename');
      var im_length = $('.im_').length;

        if($('.im_').length==1){
          alert('1den az shekil olmaz')
        }else{
        var status = confirm("Are you sure you want to delete ?");  
          if(status==true)
          {
            $(".img-wrap[data-remove='"+name+"']").remove();
            $("input[imagename='"+name+"']").val(0);
            $.ajax({
              url: '/deleteAjax',
              type: 'POST',
              dataType: 'json',
              headers:{
            'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
              },
              data: 
              {"imagefile":name,
              "im_length":im_length
              },
            success: function(img_error){
                // $('#ajaxErrorImage').append('<p style="padding:10px;">Birdən az şəkil olmaz</p>'); 
              }
            })
          }
        }
    })
// ----------------------------ISTEK EDIT WHEN CLICKING X ON PIC END-----------------------------------------------


// ----------------------------SHOW PIC ON TENZIMLEMLER-----------------------------------------------

    $('.imgInput').change(function(e){
    var file = e.originalEvent.srcElement.files;
    var check = checkExtension(file[0].name).toLowerCase(); 
        
        if(check=='jpg' || check=='jpeg' || check=='png'){
           $('.profil-avatar').empty();

            var img = document.createElement("img");
            var reader = new FileReader();
            reader.onload = function(e) {
              img.src = e.target.result;
              img.className = 'center-block'
            }
            reader.readAsDataURL(file[0]);
            $('.profil-avatar').append(img);
          }else{
             $('#ErrorImage').attr('class', 'alert alert-danger');
             $('#ErrorImage').append('<p>Düzgün şəkil seçin</p>'); 
            }     

    });
// ----------------------------SHOW PIC ON TENZIMLEMLER END-----------------------------------------------




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

//-----------------------------For destek button  -------------------------------------------
$(".destek-ol-message").hide();
    $(".destek-ol-button").click(function(){
        $(".destek-ol-message").slideToggle();

    });
 //-----------------------------For destek button  End-------------------------------------------


//------------------------------For searchBoxDrag -----------------------------------------
$('#searchBoxDrag').draggable({
          containment: '#InfoMap'
      });
});
//------------------------------For searchBoxDrag End -------------------------------------


//------------------------------For Login Ajax --------------------------------------------
$('#SubmitLogin').submit(function(event) {
  $('#EmailGroup').removeClass('has-error')
  $('#PasswordGroup').removeClass('has-error')
  $('#EmailError').html('');
  $('#PasswordError').html('');
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
    beforeSend:function(){
      $('#submit').val('...');
    },
    complete:function(){
      $('#submit').val('Daxil ol');
    },
    error:function(data){
      var errors = data.responseJSON;
      if (errors['email'] == 'The email field is required.') {
        var ForEmailError = 'Emaili boş buraxmayın';
        $('#EmailGroup').addClass('has-error')
      }
      if (errors['password'] == 'The password field is required.') {
        var ForPasswordError = 'Şifreni boş buraxmayın';
        $('#PasswordGroup').addClass('has-error')
      }else {
         location.reload();
      }
      $('#EmailError').html(ForEmailError);
      $('#PasswordError').html(ForPasswordError);
    }
  })
  Login.done(function(data) {
    location.reload();
  })
});
//------------------------------For Login Ajax End ----------------------------------------

//------------------------------For facebook share button window----------------------------------------
var popupSize = {
   width: 780,
   height: 550
};

$(document).on('click', '.social-buttons > a', function(e){

   var
        verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
        horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

   var popup = window.open($(this).prop('href'), 'social',
        'width='+popupSize.width+',height='+popupSize.height+
        ',left='+verticalPos+',top='+horisontalPos+
        ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

   if (popup) {
        popup.focus();
        e.preventDefault();
   }

});
//------------------------------For facebook share button window End ----------------------------------------

// ----------------------------For Map in destek_add and istek_add pages-----------------------------------------------
function initAutocomplete() {
var MyLocation = document.getElementById('MyLocation')
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {  lat: 40.100,lng: 47.500},
    zoom: 7,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    zoomControl:false,
    streetViewControl:false,
    mapTypeControl:false,
    overViewMapControl:false
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('adress');
  var searchBox = new google.maps.places.SearchBox(input);
  // map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });
  var markers = [];
  var geocoder = new google.maps.Geocoder;
  MyLocation.addEventListener('click',function(){
    if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.setCenter(latlng);
                map.setZoom(15);
                var marker = new google.maps.Marker({
                  position: latlng,
                  map: map,
                });
                  geocodeLatLng(geocoder, map);
                function geocodeLatLng(geocoder, map) {
                  geocoder.geocode({'location': latlng}, function(results, status) {
                    if (status === 'OK') {
                      if (results[1]) {
                        document.getElementById('adress').value = results[1].formatted_address;
                        document.getElementById('lat').value = position.coords.latitude;
                        document.getElementById('lng').value = position.coords.longitude;
                      } else {
                        window.alert('No results found');
                      }
                    } else {
                      window.alert('Geocoder failed due to: ' + status);
                    }
                  });
                }
                markers.push(marker);
            });
        };
  });

  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        animation: google.maps.Animation.DROP,
        position: place.geometry.location
      })
    );
      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
          document.getElementById('lat').value = place.geometry.location.lat();
          document.getElementById('lng').value = place.geometry.location.lng();


      } else {
        bounds.extend(place.geometry.location);
        document.getElementById('lat').value = place.geometry.location.lat();
        document.getElementById('lng').value = place.geometry.location.lng();

      }
    });
    map.fitBounds(bounds);
  });
}

//-----------------------------For Map End -------------------------------------------
